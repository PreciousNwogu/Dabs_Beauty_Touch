<?php

namespace App\Services;

use Illuminate\Support\Arr;

class PriceCalculator
{
    /**
     * Calculate pricing breakdown for a booking request.
     * Accepts array with keys: service_input, service_model (optional), service_type,
     * length, kb_length, kb_extras, hair_mask_option (optional), selector (optional)
     *
     * Returns associative array:
     *  - base_price
     *  - length_adjustment
     *  - addons_total
     *  - final_price
     *  - kb_base_price, kb_length_adjustment, kb_final_price
     *  - hair_mask_option_normalized
     */
    public function calculate(array $data = []): array
    {
        $serviceInput = Arr::get($data, 'service_input');
        $serviceModel = Arr::get($data, 'service_model');
        $serviceType = strtolower(trim((string) Arr::get($data, 'service_type', $serviceInput ?? '')));

        // Prefer model base price when present
        $basePrice = $serviceModel && isset($serviceModel->base_price) ? (float) $serviceModel->base_price : null;

        // Fallbacks from config
        if ($basePrice === null) {
            if (
                str_contains($serviceType, 'hair-mask') ||
                str_contains($serviceType, 'mask') ||
                str_contains($serviceType, 'relax') ||
                str_contains($serviceType, 'retouch')
            ) {
                $basePrice = (float) config('service_prices.hair_mask', 50);
            } elseif (str_contains($serviceType, 'kids')) {
                $basePrice = (float) config('service_prices.kids_braids', 80);
            } else {
                // generic fallback
                $slug = $serviceInput ? str_replace(' ', '_', strtolower($serviceInput)) : null;
                $basePrice = $slug ? (float) config('service_prices.' . $slug, 150) : (float) config('service_prices.default', 150);
            }
        }

        $length = Arr::get($data, 'kb_length') ?? Arr::get($data, 'length') ?? 'mid_back';
        if (is_string($length)) $length = str_replace('-', '_', $length);

        // Normalize hair mask option
        $explicitMask = Arr::get($data, 'hair_mask_option') ?? Arr::get($data, 'selectedHairMaskOption') ?? null;
        $maskNormalized = null;
        if ($explicitMask !== null) {
            $raw = strtolower(trim((string)$explicitMask));
            $raw = str_replace(['_', ' '], '-', $raw);
            if (strpos($raw, 'weav') !== false || strpos($raw, 'weave') !== false) {
                $maskNormalized = 'mask-with-weave';
            } elseif (strpos($raw, 'mask') !== false || strpos($raw, 'relax') !== false) {
                $maskNormalized = 'mask-only';
            } else {
                $maskNormalized = in_array($raw, ['mask-with-weave','mask-only']) ? $raw : 'mask-only';
            }
        }

        $isHairMask = (
            $serviceType === 'hair-mask' ||
            str_contains($serviceType, 'hair-mask') ||
            str_contains($serviceType, 'mask') ||
            str_contains($serviceType, 'relax') ||
            str_contains($serviceType, 'retouch')
        );

        $lengthAdjustment = 0.0;
        $addonsTotal = 0.0;
        $finalPrice = 0.0;
        $adjust = 0.0;

        if ($isHairMask) {
            $useMask = $maskNormalized ?? 'mask-only';
            if ($useMask === 'mask-with-weave') {
                // Base is $50 and weave add-on is +$30 => $80 total
                $base = (float) config('service_prices.hair_mask', 50);
                $addon = 30.00;
                $adjust = 0.00;
                $lengthAdjustment = 0.00;
                $addonsTotal = 30.00;
                $finalPrice = round($base + $addon, 2);
                $basePrice = $base; // persist canonical base price
            } else {
                // $50 for mask-only
                $base = $basePrice;
                $addon = 0.00;
                $adjust = 0.00;
                $finalPrice = round($base, 2);
                $lengthAdjustment = 0.00;
                $addonsTotal = 0.00;
            }
        } else {
            // Length adjustment pricing with grouped lengths:
            // - neck, shoulder, armpit: same price (-$40)
            // - bra_strap, mid_back: base/default price ($0 adjustment)
            // - waist: +$20
            // - hip: +$40 (waist + $20)
            // - tailbone, classic: same price (+$60)
            $lengthAdjustmentMap = [
                'neck' => -40.00,      // Same as shoulder and armpit
                'shoulder' => -40.00,   // Same as neck and armpit
                'armpit' => -40.00,     // Same as neck and shoulder
                'bra_strap' => 0.00,    // Base/default price (same as mid_back)
                'mid_back' => 0.00,     // Base/default price (same as bra_strap)
                'waist' => 20.00,
                'hip' => 40.00,        // Waist + $20
                'tailbone' => 60.00,    // Same as classic
                'classic' => 60.00,    // Same as tailbone
            ];
            
            $lengthAdjustment = $lengthAdjustmentMap[$length] ?? 0.00;
            $finalPrice = round($basePrice + $lengthAdjustment, 2);
        }

        // Kids selector extras parsing
        $kb_base_price = null;
        $kb_length_adjustment = null;
        $kb_final_price = null;
        $kb_extras_total = 0.0;
        $isKids = (bool) (Arr::get($data, 'kb_length') || str_contains($serviceType, 'kids'));
        if ($isKids) {
            $kb_base_price = $serviceModel && isset($serviceModel->base_price) ? (float) $serviceModel->base_price : (float) config('service_prices.kids_braids', 80);
            $kb_length = Arr::get($data, 'kb_length') ?? Arr::get($data, 'length');
            if (is_string($kb_length)) $kb_length = str_replace(['-', ' '], '_', strtolower($kb_length));
            
            // Length adjustment pricing with grouped lengths (same as regular bookings)
            $lengthAdjustmentMap = [
                'neck' => -40.00,      // Same as shoulder and armpit
                'shoulder' => -40.00,   // Same as neck and armpit
                'armpit' => -40.00,     // Same as neck and shoulder
                'bra_strap' => 0.00,    // Base/default price (same as mid_back)
                'mid_back' => 0.00,     // Base/default price (same as bra_strap)
                'waist' => 20.00,
                'hip' => 40.00,        // Waist + $20
                'tailbone' => 60.00,    // Same as classic
                'classic' => 60.00,    // Same as tailbone
            ];
            
            $kb_length_adjustment = $lengthAdjustmentMap[$kb_length] ?? 0.00;
            $kb_extras_raw = Arr::get($data, 'kb_extras');
            if (!empty($kb_extras_raw)) {
                if (is_string($kb_extras_raw) && preg_match('/^\d+(?:\.\d+)?(?:,\d+(?:\.\d+)?)*$/', $kb_extras_raw)) {
                    $parts = array_map('floatval', explode(',', $kb_extras_raw));
                    $kb_extras_total = array_sum($parts);
                } else {
                    $addonMap = ['kb_add_detangle'=>15,'kb_add_beads'=>10,'kb_add_beads_full'=>15,'kb_add_extension'=>20,'kb_add_rest'=>5];
                    foreach (explode(',', $kb_extras_raw) as $it) { $it = trim($it); if (isset($addonMap[$it])) $kb_extras_total += $addonMap[$it]; }
                }
            }
            $kb_final_price = round(($kb_base_price ?? 0) + ($kb_length_adjustment ?? 0) + ($kb_extras_total ?? 0), 2);
        }

        return [
            'base_price' => $basePrice,
            'length_adjustment' => $lengthAdjustment,
            'addons_total' => $addonsTotal,
            'final_price' => $finalPrice,
            'hair_mask_option_normalized' => $maskNormalized,
            'kb_base_price' => $kb_base_price,
            'kb_length_adjustment' => $kb_length_adjustment,
            'kb_extras_total' => $kb_extras_total,
            'kb_final_price' => $kb_final_price,
        ];
    }
}
