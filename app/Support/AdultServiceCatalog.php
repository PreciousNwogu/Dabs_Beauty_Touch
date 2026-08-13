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
            'weave-braid-mixed' => ['weave-braid-mixed', 'weave_braid_mixed', 'weave-and-braid-mixed', 'weave_and_braid_mixed'],
        ];

        $list = $aliases[$slug] ?? [$slug];
        $underscore = str_replace('-', '_', $slug);
        if ($underscore !== $slug && !in_array($underscore, $list, true)) {
            $list[] = $underscore;
        }
        $parts = array_values(array_filter(explode('-', $slug)));
        if (count($parts) >= 2) {
            $withAnd = $parts[0] . '-and-' . implode('-', array_slice($parts, 1));
            if (!in_array($withAnd, $list, true)) {
                $list[] = $withAnd;
            }
            $withAndUnderscore = str_replace('-', '_', $withAnd);
            if (!in_array($withAndUnderscore, $list, true)) {
                $list[] = $withAndUnderscore;
            }
        }

        return array_values(array_unique($list));
    }

    /** Collapse slug/name differences like &, and, underscores, and punctuation. */
    public static function normalizeMatchKey(?string $value): string
    {
        $v = strtolower(trim((string) $value));
        if ($v === '') {
            return '';
        }
        $v = str_replace(['&', '+', '_', '/'], [' and ', ' and ', '-', ' '], $v);
        $v = preg_replace('/[^a-z0-9]+/', ' ', $v) ?? $v;
        $v = preg_replace('/\b(and|the|a|of|with|no|extension|extention)\b/', ' ', $v) ?? $v;

        return (string) preg_replace('/\s+/', '', $v);
    }

    public static function isKidsCmsStyle(?string $slug, ?string $name = null): bool
    {
        $slug = (string) $slug;
        $name = strtolower(trim((string) $name));
        if ($slug === 'kids-braids') {
            return false;
        }
        if ($name !== '' && preg_match('/^kids(\s|$)/', $name)) {
            return true;
        }
        foreach (KidsStyleCatalog::definitions() as $def) {
            $slugs = array_merge([$def['slug'] ?? ''], $def['alt_slugs'] ?? []);
            if (in_array($slug, $slugs, true)) {
                return true;
            }
        }

        return false;
    }

    /** Hardcoded homepage slug controlled by this CMS row, if any. */
    public static function hardcodedSlugForCms(?string $slug, ?string $name = null): ?string
    {
        $slug = (string) $slug;
        if (self::isKidsCmsStyle($slug, $name)) {
            return null;
        }
        if ($slug !== '' && isset(self::hardcodedCategoryBySlug()[$slug])) {
            return $slug;
        }
        foreach (self::hardcodedSlugs() as $hard) {
            if ($slug !== '' && in_array($slug, self::cmsSlugsForHardcoded($hard), true)) {
                return $hard;
            }
        }

        $keys = [];
        if ($slug !== '') {
            $keys[] = self::normalizeMatchKey($slug);
        }
        if (trim((string) $name) !== '') {
            $keys[] = self::normalizeMatchKey($name);
        }
        $keys = array_values(array_filter(array_unique($keys)));
        foreach (self::hardcodedSlugs() as $hard) {
            $hardKey = self::normalizeMatchKey($hard);
            if ($hardKey === '') {
                continue;
            }
            foreach ($keys as $key) {
                if ($key === $hardKey) {
                    return $hard;
                }
            }
        }

        return null;
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

    public static function isHalfWeaveStyle($svc): bool
    {
        $slug = strtolower((string) (is_object($svc) ? ($svc->slug ?? '') : ($svc['slug'] ?? '')));
        $name = strtolower((string) (is_object($svc) ? ($svc->name ?? '') : ($svc['name'] ?? '')));

        return str_contains($slug, '1-2-weave')
            || str_contains($slug, 'half-weave')
            || str_contains($slug, 'half_weave')
            || (bool) preg_match('/1\s*\/\s*2\s*weave|half\s*weave/', $name);
    }

    /** CMS styles that keep one picker card and show braid-size radios after selection. */
    public static function wantsInlineBraidSizePicker($svc): bool
    {
        if (self::isHalfWeaveStyle($svc)) {
            return true;
        }

        $options = is_object($svc) ? ($svc->size_options ?? null) : ($svc['size_options'] ?? null);
        if (is_string($options)) {
            $options = json_decode($options, true);
        }

        return is_array($options) && $options !== [];
    }

    /** Offsets from the Medium/base price for inline braid-size radios. */
    public static function inlineBraidSizeAdjustments(): array
    {
        return [
            'small' => 40,
            'smedium' => 20,
            'medium' => 0,
            'large' => -20,
        ];
    }

    public static function suggestedSizePrice(float $base, string $sizeKey): int
    {
        return max(0, (int) round($base + (self::inlineBraidSizeAdjustments()[$sizeKey] ?? 0)));
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
            if (self::isHalfWeaveStyle($service) && isset(self::inlineBraidSizeAdjustments()[$sizeKey])) {
                $base = is_object($service) ? (float) $service->base_price : (float) ($service['base_price'] ?? 0);
                $effective = is_object($service) && isset($service->effective_price)
                    ? (float) $service->effective_price
                    : $base;

                return max(0, round($effective + self::inlineBraidSizeAdjustments()[$sizeKey], 2));
            }

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
            if (self::isHardcodedSlug($svc->slug, $svc->name ?? null)) {
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

            if (self::wantsInlineBraidSizePicker($svc)) {
                $braidSizes = [];
                foreach (self::sizeLabels() as $sizeKey => $sizeLabel) {
                    $hasCmsPrice = isset($sizeOptions[$sizeKey]) && is_numeric($sizeOptions[$sizeKey]);
                    if (!$hasCmsPrice && !self::isHalfWeaveStyle($svc)) {
                        continue;
                    }
                    $sizePrice = $hasCmsPrice
                        ? (int) round((float) self::sizePrice($svc, $sizeKey))
                        : self::suggestedSizePrice($effective, $sizeKey);
                    $listed = $hasCmsPrice ? (int) $sizeOptions[$sizeKey] : $sizePrice;
                    $braidSizes[] = [
                        'key' => $sizeKey,
                        'label' => $sizeLabel,
                        'price' => max(0, $sizePrice),
                        'original' => ($listed > $sizePrice) ? $listed : null,
                    ];
                }
                $byKey[$key][] = array_merge($shared, [
                    'name' => $svc->name,
                    'slug' => $svc->slug,
                    'price' => $effective,
                    'original' => ($original > $effective) ? $original : null,
                    'braidSizes' => $braidSizes,
                ]);
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
            foreach (Service::query()->get() as $svc) {
                if (empty($svc->slug)) {
                    continue;
                }
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

    public static function isHardcodedSlug(?string $slug, ?string $name = null): bool
    {
        return self::hardcodedSlugForCms($slug, $name) !== null;
    }

    private static function overlayServiceForSlug(array $bySlug, array $byName, string $slug)
    {
        foreach (self::cmsSlugsForHardcoded($slug) as $try) {
            if (isset($bySlug[$try])) {
                return $bySlug[$try];
            }
        }

        foreach ($bySlug as $svc) {
            if (self::hardcodedSlugForCms($svc->slug ?? '', $svc->name ?? null) === $slug) {
                return $svc;
            }
        }

        $requiredName = strtolower(trim((string) (self::requiredCmsServices()[$slug]['name'] ?? '')));
        if ($requiredName !== '' && isset($byName[$requiredName])) {
            return $byName[$requiredName];
        }

        $hardKey = self::normalizeMatchKey($slug);
        if ($hardKey !== '') {
            foreach ($byName as $nameKey => $svc) {
                if (self::normalizeMatchKey($nameKey) === $hardKey) {
                    return $svc;
                }
            }
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
            'hidden' => empty($svc->is_active),
        ];

        $braidSizes = [];
        if (self::wantsInlineBraidSizePicker($svc)) {
            foreach (self::sizeLabels() as $sizeKey => $sizeLabel) {
                $hasCmsPrice = isset($sizeOptions[$sizeKey]) && is_numeric($sizeOptions[$sizeKey]);
                if (!$hasCmsPrice && !self::isHalfWeaveStyle($svc)) {
                    continue;
                }
                $sizePrice = $hasCmsPrice
                    ? (int) round((float) self::sizePrice($svc, $sizeKey))
                    : self::suggestedSizePrice($effective, $sizeKey);
                $braidSizes[] = [
                    'key' => $sizeKey,
                    'label' => $sizeLabel,
                    'price' => max(0, $sizePrice),
                    'original' => null,
                ];
            }
        }
        if ($braidSizes) {
            $card['braidSizes'] = $braidSizes;
        }

        $variants = [];
        if (!$braidSizes) {
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
        }

        return [
            'card' => $card,
            'variants' => $variants,
            'hidden' => !empty($card['hidden']),
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
