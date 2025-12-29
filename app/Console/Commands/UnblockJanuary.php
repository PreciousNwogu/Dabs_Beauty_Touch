<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UnblockJanuary extends Command
{
    protected $signature = 'schedule:unblock-january {year?}';
    protected $description = 'Unblock all January dates by deleting blocked schedules that overlap with January';

    public function handle()
    {
        $year = $this->argument('year') ? (int)$this->argument('year') : date('Y');
        $janStart = Carbon::create($year, 1, 1)->startOfDay();
        $janEnd = Carbon::create($year, 1, 31)->endOfDay();
        
        $this->info("Looking for blocked schedules in January {$year}...");
        $this->info("Date range: {$janStart->format('Y-m-d')} to {$janEnd->format('Y-m-d')}");
        $this->newLine();
        
        // Find all blocked schedules that overlap with January
        $blockedSchedules = Schedule::where('type', 'blocked')
            ->where(function($query) use ($janStart, $janEnd) {
                $query->where(function($q) use ($janStart, $janEnd) {
                    // Schedule starts before or during January and ends after January starts
                    $q->where('start', '<=', $janEnd)
                      ->where('end', '>', $janStart);
                });
            })
            ->get();
        
        if ($blockedSchedules->isEmpty()) {
            $this->info("No blocked schedules found for January {$year}.");
            return 0;
        }
        
        $this->info("Found {$blockedSchedules->count()} blocked schedule(s):");
        foreach ($blockedSchedules as $schedule) {
            $title = $schedule->title ?? 'Untitled';
            $start = Carbon::parse($schedule->start)->format('Y-m-d');
            $end = Carbon::parse($schedule->end)->format('Y-m-d');
            $this->line("  - {$title} (from {$start} to {$end})");
        }
        
        $this->newLine();
        
        if (!$this->confirm('Do you want to delete these blocked schedules?', true)) {
            $this->info('Operation cancelled.');
            return 0;
        }
        
        $this->info('Deleting blocked schedules...');
        $deletedCount = 0;
        $deletedTitles = [];
        
        foreach ($blockedSchedules as $schedule) {
            $deletedTitles[] = $schedule->title ?? 'Untitled';
            $schedule->delete();
            $deletedCount++;
        }
        
        Log::info('Unblocked January dates', [
            'year' => $year,
            'deleted_count' => $deletedCount,
            'deleted_schedules' => $deletedTitles
        ]);
        
        $this->newLine();
        $this->info("✓ Successfully unblocked {$deletedCount} schedule(s) for January {$year}.");
        $this->info('The following schedules were deleted:');
        foreach ($deletedTitles as $title) {
            $this->line("  - {$title}");
        }
        
        return 0;
    }
}

