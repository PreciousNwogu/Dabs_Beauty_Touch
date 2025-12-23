<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CancelBookingsRange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:cancel-range
                            {--start= : Start date (YYYY-MM-DD)}
                            {--end= : End date (YYYY-MM-DD)}
                            {--reason= : Reason/notes to record in status history}
                            {--force : Cancel regardless of current status (including completed)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel bookings in a date range (defaults to 2025-12-22 through 2025-12-31)';

    public function handle()
    {
        $defaultStart = '2025-12-22';
        $defaultEnd = '2025-12-31';

        $start = $this->option('start') ?: $defaultStart;
        $end = $this->option('end') ?: $defaultEnd;
        $reason = $this->option('reason') ?: 'Cancelled by admin script for date range';
        $force = $this->option('force') ? true : false;

        try {
            $s = Carbon::createFromFormat('Y-m-d', $start)->startOfDay();
            $e = Carbon::createFromFormat('Y-m-d', $end)->endOfDay();
        } catch (\Exception $ex) {
            $this->error('Invalid date format. Use YYYY-MM-DD.');
            return 1;
        }

        $this->info("Cancelling bookings from {$s->toDateString()} to {$e->toDateString()} (inclusive)");

        DB::beginTransaction();
        try {
            $query = Booking::whereDate('appointment_date', '>=', $s->toDateString())
                            ->whereDate('appointment_date', '<=', $e->toDateString());

            if (!$force) {
                $query->whereIn('status', ['pending', 'confirmed']);
            }

            $bookings = $query->get();

            if ($bookings->isEmpty()) {
                $this->info('No matching bookings found.');
                DB::rollBack();
                return 0;
            }

            $this->info('Found ' . $bookings->count() . ' booking(s) to cancel.');

            foreach ($bookings as $b) {
                try {
                    $this->line("- Cancelling booking #{$b->id} ({$b->name}) on {$b->appointment_date}");
                    $b->updateStatus('cancelled', 'admin-script', $reason);
                } catch (\Exception $e) {
                    $this->error("Failed to cancel booking #{$b->id}: " . $e->getMessage());
                }
            }

            DB::commit();
            $this->info('Done. All matched bookings have been marked cancelled.');
            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Operation failed: ' . $e->getMessage());
            return 1;
        }
    }
}
