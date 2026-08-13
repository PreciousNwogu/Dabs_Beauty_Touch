<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class AdultServiceCatalog
{
    /** Homepage adult category key => display name. */
    public static function categories(): array
    {
        return [
            'knotless' => 'Knotless Braids',
            'boho' => 'Boho Braids',
            'twist' => 'Twist Braid',
            'natural-hair-twist' => 'Natural Hair Twist',
            'kinky-passion-twist' => 'Kinky & Passion Twists',
            'cornrow' => 'Cornrow/Feed-in Braids',
            'french-curl' => 'French Curl Braids',
            'crotchet' => 'Crotchet Styles',
            'hair-treatment' => 'Hair Treatment Services',
        ];
    }

    /** Slugs already rendered inside hardcoded homepage cards. */
    public static function hardcodedSlugs(): array
    {
        return array_keys(self::hardcodedCategoryBySlug());
    }

    /** Homepage category label for each existing card slug. */
    public static function hardcodedCategoryBySlug(): array
    {
        return [
            'small-knotless' => 'Knotless Braids',
            'smedium-knotless' => 'Knotless Braids',
            'medium-knotless' => 'Knotless Braids',
            'jumbo-knotless' => 'Knotless Braids',
            'small-boho' => 'Boho Braids',
            'smedium-boho' => 'Boho Braids',
            'medium-boho' => 'Boho Braids',
            'jumbo-boho' => 'Boho Braids',
            'small-twist' => 'Twist Braid',
            'medium-twist' => 'Twist Braid',
            'jumbo-twist' => 'Twist Braid',
            'small-natural-hair-twist' => 'Natural Hair Twist',
            'medium-natural-hair-twist' => 'Natural Hair Twist',
            'kinky-twist' => 'Kinky & Passion Twists',
            'passion-twist' => 'Kinky & Passion Twists',
            'twist-braids' => 'Kinky & Passion Twists',
            'stitch-weave' => 'Cornrow/Feed-in Braids',
            'cornrow-weave' => 'Cornrow/Feed-in Braids',
            'under-wig-weave' => 'Cornrow/Feed-in Braids',
            'weave-braid-mixed' => 'Cornrow/Feed-in Braids',
            'small-french-curl' => 'French Curl Braids',
            'smedium-french-curl' => 'French Curl Braids',
            'medium-french-curl' => 'French Curl Braids',
            'large-french-curl' => 'French Curl Braids',
            'line-single' => 'Crotchet Styles',
            'afro-crotchet' => 'Crotchet Styles',
            'individual-loc' => 'Crotchet Styles',
            'individual-crotchet' => 'Crotchet Styles',
            'butterfly-locks' => 'Crotchet Styles',
            'weave-crotchet' => 'Crotchet Styles',
            'natural-hair-treatment' => 'Hair Treatment Services',
            'chemical-relaxer' => 'Hair Treatment Services',
            'hair-mask' => 'Hair Treatment Services',
            'kids-braids' => 'Kids Braids',
            'stitch-braids' => 'Cornrow/Feed-in Braids',
            'weaving-crotchet' => 'Crotchet Styles',
            'single-crotchet' => 'Crotchet Styles',
            'natural-hair-twist' => 'Natural Hair Twist',
            'weaving-no-extension' => 'Cornrow/Feed-in Braids',
            'wig-installation' => 'Hair Treatment Services',
            'custom' => 'Hair Treatment Services',
        ];
    }

    /** Alternate CMS slugs that should overlay a hardcoded card. */
    public static function cmsSlugsForHardcoded(string $slug): array
    {
        $aliases = [
            'individual-crotchet' => ['individual-crotchet', 'individual-loc'],
            'individual-loc' => ['individual-loc', 'individual-crotchet'],
            'natural-hair-treatment' => ['natural-hair-treatment', 'hair-mask'],
        ];

        return $aliases[$slug] ?? [$slug];
    }

    public static function sizeLabels(): array
    {
        return [
            'small' => 'Small',
            'smedium' => 'Smedium',
            'medium' => 'Medium',
            'large' => 'Large',
        ];
    }

    public static function parseSizeSlug(?string $slug): array
    {
        $slug = (string) $slug;
        if (preg_match('/^(.*)--(small|smedium|medium|large)$/', $slug, $m)) {
            return ['slug' => $m[1], 'size' => $m[2]];
        }

        return ['slug' => $slug, 'size' => null];
    }

    public static function sizePrice($service, ?string $sizeKey): ?float
    {
        if (!$service || !$sizeKey) {
            return null;
        }

        $options = is_object($service) ? ($service->size_options ?? null) : ($service['size_options'] ?? null);
        if (is_string($options)) {
            $options = json_decode($options, true);
        }
        if (!is_array($options) || !isset($options[$sizeKey]) || !is_numeric($options[$sizeKey])) {
            return null;
        }

        $sizePrice = (float) $options[$sizeKey];
        $base = is_object($service) ? (float) $service->base_price : (float) ($service['base_price'] ?? 0);
        $effective = is_object($service) && isset($service->effective_price)
            ? (float) $service->effective_price
            : $base;
        if ($base > 0 && $effective < $base) {
            return round($sizePrice * ($effective / $base), 2);
        }

        return $sizePrice;
    }

    public static function keyFromName(?string $name): ?string
    {
        $name = trim((string) $name);
        if ($name === '') {
            return null;
        }

        foreach (self::categories() as $key => $label) {
            if (strcasecmp($label, $name) === 0) {
                return $key;
            }
        }

        return Str::slug($name);
    }

    public static function mergedNames($dbCategories = []): Collection
    {
        return collect(self::categories())
            ->values()
            ->merge($dbCategories)
            ->filter()
            ->reject(fn ($cat) => strcasecmp((string) $cat, 'Kids Braids') === 0)
            ->unique(fn ($cat) => strtolower((string) $cat))
            ->sort()
            ->values();
    }

    /**
     * CMS adult styles to inject into homepage/calendar size maps.
     *
     * @return array{sizes: array<string, array<int, array<string, mixed>>>, custom_cards: array<int, array<string, mixed>>}
     */
    public static function injectables($extraServices): array
    {
        $hardcoded = self::hardcodedSlugs();
        $knownKeys = array_keys(self::categories());
        $byKey = [];
        $customCards = [];

        foreach ($extraServices ?? [] as $svc) {
            if (!empty($svc->for_kids)) {
                continue;
            }
            if (in_array($svc->slug, $hardcoded, true)) {
                continue;
            }
            if (empty($svc->category)) {
                continue;
            }

            $key = self::keyFromName($svc->category);
            if (!$key) {
                continue;
            }

            $hasLength = !isset($svc->has_length) || (bool) $svc->has_length;
            $effective = (int) $svc->effective_price;
            $original = (int) $svc->base_price;
            $sizeOptions = is_array($svc->size_options ?? null) ? $svc->size_options : [];
            $rowFlags = self::rowFlags($svc);
            $shared = [
                'time' => (string) ($svc->duration ?? ''),
                'noLength' => !$hasLength,
                'hasTipFinish' => !empty($svc->has_tip_finish),
                'hasEightToTenRows' => $rowFlags['hasEightToTenRows'],
                'hasTenPlusRows' => $rowFlags['hasTenPlusRows'],
                'hasFifteenPlusRows' => $rowFlags['hasFifteenPlusRows'],
                'hasRowOptions' => $rowFlags['hasRowOptions'],
                'eightToTenRowsPrice' => $rowFlags['eightToTenRowsPrice'],
                'tenPlusRowsPrice' => $rowFlags['tenPlusRowsPrice'],
                'fifteenPlusRowsPrice' => $rowFlags['fifteenPlusRowsPrice'],
                'image' => (string) ($svc->image_url ?? ''),
                'cms' => true,
            ];

            if ($sizeOptions) {
                foreach (self::sizeLabels() as $sizeKey => $sizeLabel) {
                    if (!isset($sizeOptions[$sizeKey]) || !is_numeric($sizeOptions[$sizeKey])) {
                        continue;
                    }
                    $sizePrice = (int) round((float) self::sizePrice($svc, $sizeKey));
                    $sizeOriginal = (int) $sizeOptions[$sizeKey];
                    $byKey[$key][] = array_merge($shared, [
                        'name' => $svc->name . ' — ' . $sizeLabel,
                        'slug' => $svc->slug . '--' . $sizeKey,
                        'price' => $sizePrice,
                        'original' => ($sizeOriginal > $sizePrice) ? $sizeOriginal : null,
                        'braidSize' => $sizeKey,
                    ]);
                }
            } else {
                $byKey[$key][] = array_merge($shared, [
                    'name' => $svc->name,
                    'slug' => $svc->slug,
                    'price' => $effective,
                    'original' => ($original > $effective) ? $original : null,
                ]);
            }

            if (!in_array($key, $knownKeys, true) && !isset($customCards[$key])) {
                $customCards[$key] = [
                    'key' => $key,
                    'title' => $svc->category,
                    'image' => (string) ($svc->image_url ?? ''),
                ];
            }
        }

        return [
            'sizes' => $byKey,
            'custom_cards' => array_values($customCards),
        ];
    }

    /**
     * CMS overlays for existing hardcoded homepage cards, keyed by card slug.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function overlays($extraServices): array
    {
        $bySlug = [];
        foreach ($extraServices ?? [] as $svc) {
            if (!empty($svc->for_kids) || empty($svc->slug)) {
                continue;
            }
            $bySlug[$svc->slug] = $svc;
        }

        $overlays = [];
        foreach (self::hardcodedSlugs() as $slug) {
            $svc = null;
            foreach (self::cmsSlugsForHardcoded($slug) as $try) {
                if (isset($bySlug[$try])) {
                    $svc = $bySlug[$try];
                    break;
                }
            }
            if (!$svc) {
                continue;
            }
            $overlays[$slug] = self::overlayPayload($svc, $slug);
        }

        return $overlays;
    }

    private static function overlayPayload($svc, string $displaySlug): array
    {
        $hasLength = !isset($svc->has_length) || (bool) $svc->has_length;
        $rowFlags = self::rowFlags($svc);
        $effective = (int) $svc->effective_price;
        $original = (int) $svc->base_price;
        $sizeOptions = is_array($svc->size_options ?? null) ? $svc->size_options : [];

        $card = [
            'name' => $svc->name,
            'slug' => $displaySlug,
            'price' => $effective,
            'original' => ($original > $effective) ? $original : null,
            'time' => (string) ($svc->duration ?? ''),
            'noLength' => !$hasLength,
            'hasTipFinish' => !empty($svc->has_tip_finish),
            'hasEightToTenRows' => $rowFlags['hasEightToTenRows'],
            'hasTenPlusRows' => $rowFlags['hasTenPlusRows'],
            'hasFifteenPlusRows' => $rowFlags['hasFifteenPlusRows'],
            'hasRowOptions' => $rowFlags['hasRowOptions'],
            'eightToTenRowsPrice' => $rowFlags['eightToTenRowsPrice'],
            'tenPlusRowsPrice' => $rowFlags['tenPlusRowsPrice'],
            'fifteenPlusRowsPrice' => $rowFlags['fifteenPlusRowsPrice'],
            'image' => (string) ($svc->image_url ?? ''),
            'cms' => true,
        ];

        $variants = [];
        foreach (self::sizeLabels() as $sizeKey => $sizeLabel) {
            if (!isset($sizeOptions[$sizeKey]) || !is_numeric($sizeOptions[$sizeKey])) {
                continue;
            }
            $sizePrice = (int) round((float) self::sizePrice($svc, $sizeKey));
            $sizeOriginal = (int) $sizeOptions[$sizeKey];
            $variants[] = array_merge($card, [
                'name' => $svc->name . ' — ' . $sizeLabel,
                'slug' => $svc->slug . '--' . $sizeKey,
                'price' => $sizePrice,
                'original' => ($sizeOriginal > $sizePrice) ? $sizeOriginal : null,
                'braidSize' => $sizeKey,
            ]);
        }

        return [
            'card' => $card,
            'variants' => $variants,
        ];
    }

    public static function rowFlags($svc): array
    {
        $hasTenPlus = !empty(is_object($svc) ? ($svc->has_row_options ?? false) : ($svc['has_row_options'] ?? false));
        $hasFifteenPlus = !empty(is_object($svc) ? ($svc->has_fifteen_plus_rows ?? false) : ($svc['has_fifteen_plus_rows'] ?? false));
        $hasEightExplicit = is_object($svc)
            ? ($svc->has_eight_to_ten_rows ?? null)
            : ($svc['has_eight_to_ten_rows'] ?? null);
        $hasEightToTen = $hasEightExplicit === null
            ? ($hasTenPlus || $hasFifteenPlus)
            : !empty($hasEightExplicit);

        $eightPrice = is_object($svc) ? ($svc->eight_to_ten_rows_price ?? null) : ($svc['eight_to_ten_rows_price'] ?? null);
        $tenPrice = is_object($svc) ? ($svc->ten_plus_rows_price ?? null) : ($svc['ten_plus_rows_price'] ?? null);
        $fifteenPrice = is_object($svc) ? ($svc->fifteen_plus_rows_price ?? null) : ($svc['fifteen_plus_rows_price'] ?? null);

        return [
            'hasEightToTenRows' => $hasEightToTen,
            'hasTenPlusRows' => $hasTenPlus,
            'hasFifteenPlusRows' => $hasFifteenPlus,
            'hasRowOptions' => $hasEightToTen || $hasTenPlus || $hasFifteenPlus,
            'eightToTenRowsPrice' => $eightPrice === null || $eightPrice === '' ? 0.0 : (float) $eightPrice,
            'tenPlusRowsPrice' => $tenPrice === null || $tenPrice === '' ? 30.0 : (float) $tenPrice,
            'fifteenPlusRowsPrice' => $fifteenPrice === null || $fifteenPrice === '' ? 30.0 : (float) $fifteenPrice,
        ];
    }

    public static function rowAddonAmount($svc, ?string $option): float
    {
        $flags = self::rowFlags($svc);
        return match ($option) {
            'more_than_ten', '10+' => (float) $flags['tenPlusRowsPrice'],
            'fifteen_or_more', '15+' => (float) $flags['fifteenPlusRowsPrice'],
            'ten_or_less', '8-10' => (float) $flags['eightToTenRowsPrice'],
            default => 0.0,
        };
    }
}
