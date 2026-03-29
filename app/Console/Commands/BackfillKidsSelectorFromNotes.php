<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Console\Command;

class BackfillKidsSelectorFromNotes extends Command
{
    protected $signature = 'bookings:backfill-kids-selector
                            {--days=180 : Only scan bookings created within the last N days}
                            {--limit=1000 : Max bookings to scan}
                            {--apply : Persist updates (default is dry-run)}';

    protected $description = 'Backfill kids selector fields (braid type, finish, length, add-ons) from notes selector payload';

    public function handle(): int
    {
        $days = max(1, (int) $this->option('days'));
        $limit = max(1, (int) $this->option('limit'));
        $apply = (bool) $this->option('apply');

        $cutoff = now()->subDays($days);

        $bookings = Booking::query()
            ->where('created_at', '>=', $cutoff)
            ->where(function ($q) {
                $q->where('service', 'like', '%kids%')
                  ->orWhere('notes', 'like', '%Selector:%');
            })
            ->orderByDesc('id')
            ->limit($limit)
            ->get();

        $this->info(sprintf(
            'Scanning %d booking(s) from the last %d day(s) in %s mode...',
            $bookings->count(),
            $days,
            $apply ? 'APPLY' : 'DRY-RUN'
        ));

        $updated = 0;
        $skipped = 0;

        foreach ($bookings as $booking) {
            $selector = $this->parseSelectorFromNotes((string) ($booking->notes ?? ''));
            if (empty($selector)) {
                $skipped++;
                continue;
            }

            $braidType = $booking->kb_braid_type ?: ($selector['braid_type'] ?? $selector['kb_braid_type'] ?? null);
            $finish = $booking->kb_finish ?: ($selector['finish'] ?? $selector['kb_finish'] ?? null);
            $length = $booking->kb_length ?: ($selector['length'] ?? $selector['kb_length'] ?? null);
            $extras = $booking->kb_extras ?: ($selector['extras'] ?? $selector['kb_extras'] ?? null);

            if (is_array($extras)) {
                $extras = implode(',', array_map('strval', $extras));
            }
            if (is_string($length)) {
                $length = str_replace('-', '_', strtolower(trim($length)));
            }

            $pricing = $this->computeKidsPricing($braidType, $length, $finish, is_string($extras) ? $extras : null);

            $changes = [];
            if (empty($booking->kb_braid_type) && !empty($braidType)) {
                $changes['kb_braid_type'] = $braidType;
            }
            if (empty($booking->kb_finish) && !empty($finish)) {
                $changes['kb_finish'] = $finish;
            }
            if (empty($booking->kb_length) && !empty($length)) {
                $changes['kb_length'] = $length;
            }
            if (empty($booking->kb_extras) && !empty($extras)) {
                $changes['kb_extras'] = $extras;
            }

            if ((is_null($booking->kb_addons_total) || (float) $booking->kb_addons_total === 0.0) && ($pricing['addons'] > 0)) {
                $changes['kb_addons_total'] = round($pricing['addons'], 2);
            }
            if (is_null($booking->kb_base_price) && $pricing['base'] > 0) {
                $changes['kb_base_price'] = round($pricing['base'], 2);
            }
            if (is_null($booking->kb_length_adjustment)) {
                $changes['kb_length_adjustment'] = round($pricing['adjustments'], 2);
            }
            if ((is_null($booking->kb_final_price) || (float) $booking->kb_final_price <= 0) && $pricing['final'] > 0) {
                $changes['kb_final_price'] = round($pricing['final'], 2);
            }

            $isKidsService = str_contains(strtolower((string) ($booking->service ?? '')), 'kids');
            if ($isKidsService && (is_null($booking->final_price) || (float) $booking->final_price <= 0) && $pricing['final'] > 0) {
                $changes['final_price'] = round($pricing['final'], 2);
                $changes['base_price'] = round($pricing['base'], 2);
                $changes['length_adjustment'] = round($pricing['adjustments'], 2);
            }

            if (empty($changes)) {
                $skipped++;
                continue;
            }

            $updated++;
            $this->line(sprintf('Booking #%d: %s', $booking->id, implode(', ', array_keys($changes))));

            if ($apply) {
                $booking->forceFill($changes)->save();
            }
        }

        $this->newLine();
        $this->info(sprintf('Done. %d booking(s) %s, %d skipped.', $updated, $apply ? 'updated' : 'would be updated', $skipped));

        if (!$apply) {
            $this->comment('Run again with --apply to persist changes.');
        }

        return self::SUCCESS;
    }

    private function parseSelectorFromNotes(string $notes): ?array
    {
        if (!preg_match('/Selector:\s*(\{.*\})/s', $notes, $m)) {
            return null;
        }
        $decoded = json_decode($m[1], true);
        return is_array($decoded) ? $decoded : null;
    }

    /**
     * @return array{base: float, adjustments: float, addons: float, final: float}
     */
    private function computeKidsPricing(?string $braidType, ?string $length, ?string $finish, ?string $extras): array
    {
        $base = (float) config('service_prices.kids_braids', 80);

        $typeAdj = [
            'protective' => -20,
            'cornrows' => -40,
            'knotless_small' => 20,
            'knotless_med' => 0,
            'box_small' => 10,
            'box_med' => 0,
            'stitch' => 20,
        ];
        $lengthAdj = ['shoulder' => 0, 'armpit' => 10, 'mid_back' => 20, 'waist' => 30];
        $finishAdj = ['curled' => -10, 'plain' => 0];
        $addonMap = [
            'kb_add_detangle' => 15,
            'kb_add_beads' => 10,
            'kb_add_beads_full' => 15,
            'kb_add_extension' => 20,
            'kb_add_rest' => 5,
        ];

        $adjustments = 0.0;
        $addons = 0.0;

        $bt = $braidType ? trim($braidType) : null;
        $ln = $length ? str_replace('-', '_', strtolower(trim($length))) : null;
        $fi = $finish ? strtolower(trim($finish)) : null;

        if ($bt && str_starts_with($bt, 'cms_')) {
            $cmsId = (int) substr($bt, 4);
            $cmsSvc = Service::find($cmsId);
            if ($cmsSvc) {
                $base = (float) $cmsSvc->effective_price;
            }
        } else {
            if ($bt && isset($typeAdj[$bt])) {
                $adjustments += $typeAdj[$bt];
            }
            if ($ln && isset($lengthAdj[$ln])) {
                $adjustments += $lengthAdj[$ln];
            }
            if ($fi && isset($finishAdj[$fi])) {
                $adjustments += $finishAdj[$fi];
            }
        }

        if (!empty($extras)) {
            if (preg_match('/^\d+(?:\.\d+)?(?:,\d+(?:\.\d+)?)*$/', $extras)) {
                foreach (explode(',', $extras) as $n) {
                    $addons += (float) $n;
                }
            } else {
                foreach (explode(',', $extras) as $it) {
                    $it = trim($it);
                    if ($it !== '' && isset($addonMap[$it])) {
                        $addons += $addonMap[$it];
                    }
                }
            }
        }

        $final = round($base + $adjustments + $addons, 2);

        return [
            'base' => round($base, 2),
            'adjustments' => round($adjustments, 2),
            'addons' => round($addons, 2),
            'final' => $final,
        ];
    }
}
