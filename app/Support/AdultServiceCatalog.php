<?php

namespace App\Support;

use App\Models\Service;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
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
            'kinky-twist' => ['kinky-twist', 'kinky_twist'],
            'passion-twist' => ['passion-twist', 'passion_twist'],
        ];

        $list = $aliases[$slug] ?? [$slug];
        $underscore = str_replace('-', '_', $slug);
        if ($underscore !== $slug && !in_array($underscore, $list, true)) {
            $list[] = $underscore;
        }

        return $list;
    }

    /**
     * Homepage styles that must exist as CMS rows so they can be edited.
     *
     * @return array<string, array{name:string, base_price:int, duration:?string, category:string, has_length:bool}>
     */
    public static function requiredCmsServices(): array
    {
        return [
            'kinky-twist' => [
                'name' => 'Kinky Twist',
                'base_price' => 120,
                'duration' => '3–4 hrs',
                'category' => 'Kinky & Passion Twists',
                'has_length' => true,
            ],
            'passion-twist' => [
                'name' => 'Passion Twist',
                'base_price' => 130,
                'duration' => '3–4 hrs',
                'category' => 'Kinky & Passion Twists',
                'has_length' => true,
            ],
        ];
    }

    public static function ensureRequiredCmsServices(): void
    {
        if (!Schema::hasTable('services')) {
            return;
        }

        $now = now();
        foreach (self::requiredCmsServices() as $slug => $def) {
            if (Service::where('slug', $slug)->exists()) {
                continue;
            }

            $row = [
                'name' => $def['name'],
                'slug' => $slug,
                'base_price' => $def['base_price'],
                'discount_price' => null,
                'description' => null,
                'is_active' => true,
                'for_kids' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            if (Schema::hasColumn('services', 'category')) {
                $row['category'] = $def['category'];
            }
            if (Schema::hasColumn('services', 'duration')) {
                $row['duration'] = $def['duration'];
            }
            if (Schema::hasColumn('services', 'has_length')) {
                $row['has_length'] = $def['has_length'];
            }

            Service::query()->create($row);
        }
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

    public static function displayCategoryName(?string $name): string
    {
        $n = trim((string) $name);
        if ($n === '' || strcasecmp($n, 'other') === 0 || strcasecmp($n, 'others') === 0) {
            return 'More Styles';
        }

        return $n;
    }

    public static function displayStyleName(string $slug, ?string $name): string
    {
        if ($slug === 'line-single') {
            return '2-3 line single crotchet';
        }

        $n = trim((string) $name);
        return $n !== '' ? $n : $slug;
    }

    public static function publicImageUrl(?string $path): string
    {
        $path = trim((string) $path);
        if ($path === '') {
            return '';
        }
        if (preg_match('#^https?://#i', $path) || str_starts_with($path, '//')) {
            return $path;
        }

        $path = ltrim($path, '/');
        $parts = explode('/', $path);
        $file = array_pop($parts);
        $parts[] = rawurlencode($file);

        return asset(implode('/', $parts));
    }

    /**
     * Homepage category-card image/description overlays, keyed by card key.
     *
     * @return array<string, array{image: string, description: string}>
     */
    public static function homepageCards($extraServices): array
    {
        $cards = [];
        $services = collect($extraServices ?? []);
        try {
            if (Schema::hasColumn('services', 'use_as_category_card')) {
                $flagged = Service::where('use_as_category_card', true)->get();
                $services = $services->concat($flagged)->unique('id');
            }
        } catch (\Throwable $e) {
            // Keep using the request collection when the table is unavailable.
        }
        foreach ($services as $svc) {
            $category = $svc->category ?: (self::hardcodedCategoryBySlug()[$svc->slug] ?? null);
            $key = ($svc->slug === 'kids-braids' || strcasecmp((string) $category, 'Kids Braids') === 0)
                ? 'kids'
                : self::keyFromName($category);
            if (!$key) {
                continue;
            }

            $image = self::publicImageUrl($svc->image_url ?? '');
            $description = trim((string) ($svc->description ?? ''));
            $flagged = !empty($svc->use_as_category_card);
            $isKnownCard = isset(self::categories()[$key]) || $key === 'kids';
            if ($isKnownCard && !$flagged) {
                continue;
            }
            if ($image === '' && $description === '') {
                continue;
            }

            $existing = $cards[$key] ?? ['image' => '', 'description' => '', 'flagged' => false];
            if ($flagged) {
                $existing['flagged'] = true;
                if ($image !== '') {
                    $existing['image'] = $image;
                }
                if ($description !== '') {
                    $existing['description'] = $description;
                }
            } elseif (!$existing['flagged']) {
                if ($existing['image'] === '' && $image !== '') {
                    $existing['image'] = $image;
                }
                if ($existing['description'] === '' && $description !== '') {
                    $existing['description'] = $description;
                }
            }
            $cards[$key] = $existing;
        }

        foreach ($cards as $key => $card) {
            unset($card['flagged']);
            $cards[$key] = $card;
        }

        return $cards;
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
        $knownKeys = array_keys(self::categories());
        $byKey = [];
        $customCards = [];

        foreach ($extraServices ?? [] as $svc) {
            if (!empty($svc->for_kids)) {
                continue;
            }
            if (self::isHardcodedSlug($svc->slug)) {
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
                'image' => self::publicImageUrl($svc->image_url ?? ''),
                'description' => trim((string) ($svc->description ?? '')),
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

            if (!in_array($key, $knownKeys, true)) {
                $image = self::publicImageUrl($svc->image_url ?? '');
                $description = trim((string) ($svc->description ?? ''));
                $flagged = !empty($svc->use_as_category_card);
                if (!isset($customCards[$key])) {
                    $customCards[$key] = [
                        'key' => $key,
                        'title' => self::displayCategoryName($svc->category),
                        'image' => $image,
                        'description' => $description,
                        'flagged' => $flagged,
                    ];
                } elseif ($flagged || empty($customCards[$key]['flagged'])) {
                    if ($flagged || $customCards[$key]['image'] === '') {
                        $customCards[$key]['image'] = $image ?: $customCards[$key]['image'];
                    }
                    if ($flagged || $customCards[$key]['description'] === '') {
                        $customCards[$key]['description'] = $description !== '' ? $description : $customCards[$key]['description'];
                    }
                    if ($flagged) {
                        $customCards[$key]['flagged'] = true;
                    }
                }
            }
        }

        $customCards = array_map(function (array $card) {
            unset($card['flagged']);
            return $card;
        }, $customCards);

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
            if (empty($svc->slug)) {
                continue;
            }
            $bySlug[$svc->slug] = $svc;
        }

        try {
            $aliasSlugs = [];
            foreach (self::hardcodedSlugs() as $slug) {
                foreach (self::cmsSlugsForHardcoded($slug) as $try) {
                    $aliasSlugs[] = $try;
                }
            }
            foreach (Service::whereIn('slug', array_values(array_unique($aliasSlugs)))->get() as $svc) {
                $bySlug[$svc->slug] = $svc;
            }
        } catch (\Throwable $e) {
            // Keep using the request collection when the table is unavailable.
        }

        $byName = [];
        foreach ($bySlug as $svc) {
            $nameKey = strtolower(trim((string) $svc->name));
            if ($nameKey === '') {
                continue;
            }
            $existing = $byName[$nameKey] ?? null;
            if (!$existing || (!empty($svc->is_active) && empty($existing->is_active))) {
                $byName[$nameKey] = $svc;
            }
        }

        $overlays = [];
        foreach (self::hardcodedSlugs() as $slug) {
            $svc = self::overlayServiceForSlug($bySlug, $byName, $slug);
            if (!$svc) {
                continue;
            }
            $overlays[$slug] = self::overlayPayload($svc, $slug);
        }

        return $overlays;
    }

    public static function isHardcodedSlug(?string $slug): bool
    {
        $slug = (string) $slug;
        if ($slug === '') {
            return false;
        }
        if (in_array($slug, self::hardcodedSlugs(), true)) {
            return true;
        }
        foreach (self::hardcodedSlugs() as $hard) {
            if (in_array($slug, self::cmsSlugsForHardcoded($hard), true)) {
                return true;
            }
        }

        return false;
    }

    private static function overlayServiceForSlug(array $bySlug, array $byName, string $slug)
    {
        foreach (self::cmsSlugsForHardcoded($slug) as $try) {
            if (isset($bySlug[$try])) {
                return $bySlug[$try];
            }
        }

        $requiredName = strtolower(trim((string) (self::requiredCmsServices()[$slug]['name'] ?? '')));
        if ($requiredName !== '' && isset($byName[$requiredName])) {
            return $byName[$requiredName];
        }

        return null;
    }

    private static function overlayPayload($svc, string $displaySlug): array
    {
        $hasLength = !isset($svc->has_length) || (bool) $svc->has_length;
        $rowFlags = self::rowFlags($svc);
        $effective = (int) $svc->effective_price;
        $original = (int) $svc->base_price;
        $sizeOptions = is_array($svc->size_options ?? null) ? $svc->size_options : [];

        $card = [
            'name' => self::displayStyleName($displaySlug, $svc->name),
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
            'image' => self::publicImageUrl($svc->image_url ?? ''),
            'description' => trim((string) ($svc->description ?? '')),
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
