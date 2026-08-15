<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Support\AdminBookingFilters;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookingExportController extends Controller
{
    public function bookings(Request $request): StreamedResponse
    {
        $filename = 'dbt-bookings-'.now('America/Toronto')->format('Y-m-d').'.csv';

        return $this->csvDownload($filename, function ($out) use ($request) {
            fputcsv($out, [
                'Booking ID',
                'Confirmation',
                'Name',
                'Email',
                'Phone',
                'Service',
                'Length',
                'Appointment date',
                'Appointment time',
                'Type',
                'Address',
                'Status',
                'Payment status',
                'Amount',
                'Completed at',
                'Completed by',
                'Notes',
                'Created at',
            ]);

            $query = AdminBookingFilters::apply(Booking::query(), $request)
                ->orderBy('appointment_date')
                ->orderBy('appointment_time')
                ->orderBy('id');

            foreach ($query->cursor() as $booking) {
                fputcsv($out, [
                    'BK'.str_pad((string) $booking->id, 6, '0', STR_PAD_LEFT),
                    $booking->confirmation_code,
                    $booking->name,
                    $booking->email,
                    $booking->phone,
                    $booking->service,
                    $booking->length,
                    $this->formatDate($booking->appointment_date),
                    $this->formatTime($booking->appointment_time),
                    $booking->appointment_type,
                    $booking->address,
                    $booking->status,
                    $booking->payment_status ?: 'pending',
                    number_format(AdminBookingFilters::amount($booking), 2, '.', ''),
                    $this->formatDateTime($booking->completed_at),
                    $booking->completed_by,
                    $this->oneLine($booking->message ?: $booking->notes),
                    $this->formatDateTime($booking->created_at),
                ]);
            }
        });
    }

    public function revenue(Request $request): StreamedResponse
    {
        $filename = 'dbt-revenue-'.now('America/Toronto')->format('Y-m-d').'.csv';
        $months = max(1, min(36, (int) $request->input('months', 12)));

        return $this->csvDownload($filename, function ($out) use ($months) {
            fputcsv($out, [
                'Month',
                'Completed bookings',
                'Revenue',
                'Previous month revenue',
                'Growth %',
            ]);

            $amountSql = 'COALESCE(final_price, kb_final_price, (COALESCE(base_price, 0) + COALESCE(length_adjustment, 0)), 0)';
            $dateSql = 'DATE(COALESCE(completed_at, appointment_date))';

            $rows = Booking::query()
                ->where('status', 'completed')
                ->whereRaw($dateSql.' IS NOT NULL')
                ->selectRaw($dateSql.' as revenue_date')
                ->selectRaw($amountSql.' as revenue_amount')
                ->get();

            $byMonth = [];
            foreach ($rows as $row) {
                if (! $row->revenue_date) {
                    continue;
                }
                $key = Carbon::parse($row->revenue_date)->format('Y-m');
                $byMonth[$key]['revenue'] = ($byMonth[$key]['revenue'] ?? 0) + (float) $row->revenue_amount;
                $byMonth[$key]['count'] = ($byMonth[$key]['count'] ?? 0) + 1;
            }

            $cursor = now('America/Toronto')->startOfMonth();
            for ($i = 0; $i < $months; $i++) {
                $key = $cursor->format('Y-m');
                $prevKey = $cursor->copy()->subMonth()->format('Y-m');
                $revenue = (float) ($byMonth[$key]['revenue'] ?? 0);
                $previous = (float) ($byMonth[$prevKey]['revenue'] ?? 0);
                $growth = '';
                if ($previous > 0) {
                    $growth = number_format((($revenue - $previous) / $previous) * 100, 1, '.', '');
                } elseif ($revenue > 0) {
                    $growth = '100.0';
                }

                fputcsv($out, [
                    $cursor->format('F Y'),
                    (int) ($byMonth[$key]['count'] ?? 0),
                    number_format($revenue, 2, '.', ''),
                    number_format($previous, 2, '.', ''),
                    $growth,
                ]);

                $cursor->subMonth();
            }
        });
    }

    /**
     * @param  callable(resource): void  $writer
     */
    private function csvDownload(string $filename, callable $writer): StreamedResponse
    {
        return response()->streamDownload(function () use ($writer) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            $writer($out);
            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function formatDate(mixed $value): string
    {
        if (! $value) {
            return '';
        }

        try {
            return Carbon::parse($value)->toDateString();
        } catch (\Throwable $e) {
            return (string) $value;
        }
    }

    private function formatTime(mixed $value): string
    {
        if (! $value) {
            return '';
        }

        try {
            return Carbon::parse($value)->format('H:i');
        } catch (\Throwable $e) {
            return (string) $value;
        }
    }

    private function formatDateTime(mixed $value): string
    {
        if (! $value) {
            return '';
        }

        try {
            return Carbon::parse($value)->timezone('America/Toronto')->format('Y-m-d H:i');
        } catch (\Throwable $e) {
            return (string) $value;
        }
    }

    private function oneLine(?string $value): string
    {
        return trim(preg_replace('/\s+/', ' ', (string) $value) ?? '');
    }
}
