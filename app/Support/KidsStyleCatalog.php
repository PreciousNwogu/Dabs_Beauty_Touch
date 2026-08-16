<?php

namespace App\Support;

use App\Models\Service;
use Illuminate\Support\Facades\Schema;

class KidsStyleCatalog
{
    public const PLACEHOLDER_DESCRIPTION = 'Kids Braids selector style. Edit this price independently of other services.';

    /**
     * Built-in kids selector styles and the CMS service that owns each price.
     * Changing one of these services does not change Kids Braids or adult services.
     */
    public static function definitions(): array
    {
        return [
            'protective' => [
                'slug' => 'protective',
                'alt_slugs' => ['kids-natural-hair-twist', 'kids-protective'],
                'name' => 'Kids Natural Hair Twist',
                'default_price' => 80,
                'disable_steps' => true,
                'fallback_adj' => -20,
                'duration' => '1–2 hrs',
                'blurb' => ' Protective style on natural hair. No extensions.',
                'image' => '/images/kids-natual-hair-twist.png',
            ],
            'cornrows' => [
                'slug' => 'cornrows',
                'alt_slugs' => ['kids-cornrows'],
                'name' => 'Kids Cornrows',
                'default_price' => 50,
                'disable_steps' => true,
                'fallback_adj' => -30,
                'duration' => '0.5-1 hr',
                'blurb' => 'Classic cornrows with no extensions, quick and easy.',
                'image' => '/images/kid cornrow, no extention.png',
            ],
            'cornrow_weave' => [
                'slug' => 'cornrow_weave',
                'alt_slugs' => ['kids-cornrow-weave'],
                'name' => 'Kids Cornrow Weave',
                'default_price' => 100,
                'disable_steps' => false,
                'fallback_adj' => 0,
                'duration' => '2–3 hrs',
                'blurb' => 'Cornrows with added hair for extra fullness and length.',
                'image' => '/images/kids cornrow weave.png',
            ],
            'knotless_small' => [
                'slug' => 'knotless_small',
                'alt_slugs' => ['kids-knotless-small'],
                'name' => 'Kids Knotless Small',
                'default_price' => 120,
                'disable_steps' => false,
                'fallback_adj' => 20,
                'duration' => '3–4 hrs',
                'blurb' => 'Finer knotless braids. Smaller size, longer sit time.',
                'image' => '/images/kids small knotless.png',
            ],
            'knotless_med' => [
                'slug' => 'knotless_med',
                'alt_slugs' => ['kids-knotless-medium', 'kids-knotless-med'],
                'name' => 'Kids Knotless Medium',
                'default_price' => 100,
                'disable_steps' => false,
                'fallback_adj' => 0,
                'duration' => '2–3 hrs',
                'blurb' => 'Medium knotless braids. A popular everyday kids style.',
                'image' => '/images/kids medium knotless.png',
            ],
            'box_small' => [
                'slug' => 'box_small',
                'alt_slugs' => ['kids-box-small'],
                'name' => 'Kids Box Braids Small',
                'default_price' => 110,
                'disable_steps' => false,
                'fallback_adj' => 10,
                'duration' => '3–4 hrs',
                'blurb' => 'Smaller box braids for a neater, longer-lasting look.',
                'image' => '/images/box_braid_size_small_png.webp',
            ],
            'box_med' => [
                'slug' => 'box_med',
                'alt_slugs' => ['kids-box-medium', 'kids-box-med'],
                'name' => 'Kids Box Braids Medium',
                'default_price' => 100,
                'disable_steps' => false,
                'fallback_adj' => 0,
                'duration' => '2–3 hrs',
                'blurb' => 'Medium box braids. Less time than the small size.',
                'image' => '/images/kids medium box braid.png',
            ],
            'stitch' => [
                'slug' => 'stitch',
                'alt_slugs' => ['kids-stitch', 'kids-stitch-braids'],
                'name' => 'Kids Stitch Braids',
                'default_price' => 120,
                'disable_steps' => false,
                'fallback_adj' => 20,
                'duration' => '2–3 hrs',
                'blurb' => 'Clean stitch cornrows, neat parts, extra definition.',
                'image' => '/images/kids stitch braid.png',
            ],
            'half_weave_braid' => [
                'slug' => 'half_weave_braid',
                'alt_slugs' => ['kids-half-weave-braid'],
                'name' => 'Kids 1/2 Weave & 1/2 Braid',
                'default_price' => 120,
                'disable_steps' => false,
                'fallback_adj' => 0,
                'duration' => '2–3 hrs',
                'blurb' => 'Half weave, half braid mix for two looks in one.',
                'image' => '/images/kids half weave and half knotless.png',
            ],
            'half_weave_crotchet' => [
                'slug' => 'half_weave_crotchet',
                'alt_slugs' => ['kids-half-weave-crotchet'],
                'name' => 'Kids 1/2 Weave & 1/2 Crotchet',
                'default_price' => 100,
                'disable_steps' => true,
                'fallback_adj' => 0,
                'duration' => '1.5–2.5 hrs',
                'blurb' => 'Half weave with crotchet. No length choice needed.',
                'image' => '/images/kids half weave & half crotchet.png',
            ],
            'crotchet_style' => [
                'slug' => 'crotchet_style',
                'alt_slugs' => ['kids-crotchet-style'],
                'name' => 'Kids Crotchet Style',
                'default_price' => 90,
                'disable_steps' => true,
                'fallback_adj' => 0,
                'duration' => '1–2 hrs',
                'blurb' => 'Faster protective install with crotchet hair.',
                'image' => '/images/kids crotchet.png',
            ],
        ];
    }

    public static function slugs(): array
    {
        $slugs = [];
        foreach (self::definitions() as $def) {
            foreach (self::slugVariantsFor($def) as $slug) {
                $slugs[] = $slug;
            }
        }

        return array_values(array_unique($slugs));
    }

    /**
     * Underscore and hyphen versions of a kids catalog slug.
     * Saving in CMS runs Str::slug(), which turns box_small into box-small.
     *
     * @return list<string>
     */
    public static function slugVariantsFor(array $def): array
    {
        $raw = array_merge([$def['slug'] ?? ''], $def['alt_slugs'] ?? []);
        $adultSlugs = AdultServiceCatalog::hardcodedSlugs();
        $out = [];
        foreach ($raw as $slug) {
            $slug = trim((string) $slug);
            if ($slug === '') {
                continue;
            }
            foreach ([$slug, str_replace('_', '-', $slug), str_replace('-', '_', $slug)] as $variant) {
                // cornrow_weave → cornrow-weave would steal the adult homepage service.
                if (in_array($variant, $adultSlugs, true) && ! in_array($variant, $raw, true)) {
                    continue;
                }
                $out[] = $variant;
            }
        }

        return array_values(array_unique($out));
    }

    public static function canonicalSlug(?string $slug): ?string
    {
        $slug = trim((string) $slug);
        if ($slug === '') {
            return null;
        }
        foreach (self::definitions() as $def) {
            if (in_array($slug, self::slugVariantsFor($def), true)) {
                return $def['slug'];
            }
        }

        return null;
    }

    public static function isCatalogSlug(?string $slug): bool
    {
        return self::canonicalSlug($slug) !== null;
    }

    public static function catalogImageForSlug(?string $slug): string
    {
        $canonical = self::canonicalSlug($slug);
        if (!$canonical) {
            return '';
        }
        foreach (self::definitions() as $def) {
            if (($def['slug'] ?? '') === $canonical) {
                return (string) ($def['image'] ?? '');
            }
        }

        return '';
    }

    public static function catalogBlurbForSlug(?string $slug): string
    {
        $canonical = self::canonicalSlug($slug);
        if (!$canonical) {
            return '';
        }
        foreach (self::definitions() as $def) {
            if (($def['slug'] ?? '') === $canonical) {
                return trim((string) ($def['blurb'] ?? ''));
            }
        }

        return '';
    }

    public static function usableBlurb(?string $cmsDescription, string $fallback = ''): string
    {
        $text = trim((string) $cmsDescription);
        if ($text === '' || self::isPlaceholderDescription($text)) {
            return trim($fallback);
        }

        return $text;
    }

    public static function isPlaceholderDescription(?string $text): bool
    {
        return trim((string) $text) === self::PLACEHOLDER_DESCRIPTION;
    }

    /**
     * Insert missing built-in kids CMS rows. Does not overwrite salon edits.
     */
    public static function ensureCmsServices(): void
    {
        if (! Schema::hasTable('services')) {
            return;
        }

        $now = now();
        foreach (self::definitions() as $def) {
            $slugs = self::slugVariantsFor($def);
            $matches = Service::query()
                ->when(Schema::hasColumn('services', 'for_kids'), fn ($q) => $q->where('for_kids', true))
                ->where(function ($q) use ($slugs, $def) {
                    $q->whereIn('slug', $slugs)->orWhere('name', $def['name']);
                })
                ->get();

            if ($matches->isEmpty()) {
                $row = [
                    'name' => $def['name'],
                    'slug' => $def['slug'],
                    'base_price' => $def['default_price'],
                    'discount_price' => null,
                    'description' => trim((string) ($def['blurb'] ?? '')),
                    'is_active' => true,
                    'for_kids' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
                if (Schema::hasColumn('services', 'category')) {
                    $row['category'] = 'Kids Braids';
                }
                if (Schema::hasColumn('services', 'duration')) {
                    $row['duration'] = $def['duration'] ?? null;
                }
                if (Schema::hasColumn('services', 'has_length')) {
                    $row['has_length'] = empty($def['disable_steps']);
                }

                Service::query()->create($row);
                continue;
            }

            $keeper = $matches->firstWhere('slug', $def['slug']) ?? $matches->first();
            if ($keeper && $keeper->slug !== $def['slug'] && ! Service::query()->where('slug', $def['slug'])->exists()) {
                $keeper->slug = $def['slug'];
                $keeper->save();
            }
        }
    }

    /**
     * @return array<string, array{price:int, original:int, slug:string, from_cms:bool, image_url:string, duration:string, name:string, description:string, is_active:bool, has_length:?bool, discount_ends:?string}>
     */
    public static function cardPrices(): array
    {
        $defs = self::definitions();
        $services = collect();
        try {
            $services = Service::whereIn('slug', self::slugs())->get()->keyBy('slug');
        } catch (\Throwable $e) {
            $services = collect();
        }

        $kidsEff = (int) config('service_prices.kids_braids', 80);
        $kidsOrig = (int) config('service_prices_original.kids_braids', $kidsEff);
        $fixedFallback = ['protective', 'cornrows'];

        $out = [];
        foreach ($defs as $type => $def) {
            $svc = $services->get($def['slug']);
            if (!$svc) {
                foreach ($def['alt_slugs'] ?? [] as $alt) {
                    $svc = $services->get($alt);
                    if ($svc) {
                        break;
                    }
                }
            }

            if ($svc) {
                $out[$type] = [
                    'price' => (int) $svc->effective_price,
                    'original' => (int) $svc->base_price,
                    'slug' => $svc->slug,
                    'from_cms' => true,
                    'image_url' => (string) ($svc->image_url ?? ''),
                    'duration' => (string) ($svc->duration ?? ''),
                    'name' => (string) $svc->name,
                    'description' => (string) ($svc->description ?? ''),
                    'is_active' => (bool) $svc->is_active,
                    'has_length' => isset($svc->has_length) ? (bool) $svc->has_length : null,
                    'discount_ends' => ($svc->has_discount && $svc->discount_ends_at)
                        ? $svc->discount_ends_at->toIso8601String()
                        : '',
                ];
                continue;
            }

            $base = in_array($type, $fixedFallback, true) ? $kidsOrig : $kidsEff;
            $price = $base + (int) ($def['fallback_adj'] ?? 0);
            $out[$type] = [
                'price' => $price,
                'original' => $price,
                'slug' => $def['slug'],
                'from_cms' => false,
                'image_url' => '',
                'duration' => '',
                'name' => (string) ($def['name'] ?? ''),
                'description' => '',
                'is_active' => true,
                'has_length' => empty($def['disable_steps']),
                'discount_ends' => '',
            ];
        }

        return $out;
    }

    public static function startingPrice(?string $braidType): ?float
    {
        if (!$braidType) {
            return null;
        }

        $custom = self::resolveCustom($braidType);
        if ($custom) {
            return (float) $custom->effective_price;
        }

        $row = self::cardPrices()[$braidType] ?? null;
        return $row ? (float) $row['price'] : null;
    }

    public static function resolveCustom(?string $braidType): ?Service
    {
        if (!$braidType || !preg_match('/^cms_(\d+)$/', $braidType, $m)) {
            return null;
        }

        return Service::query()
            ->where('id', (int) $m[1])
            ->where('for_kids', true)
            ->first();
    }

    public static function customServices()
    {
        $skip = array_values(array_unique(array_merge(self::slugs(), ['kids-braids'])));

        return Service::query()
            ->where('for_kids', true)
            ->where('is_active', true)
            ->whereNotIn('slug', $skip)
            ->orderBy('name')
            ->get();
    }

    public static function usesLengthSteps(?string $braidType): bool
    {
        $custom = self::resolveCustom($braidType);
        if ($custom) {
            return !isset($custom->has_length) || (bool) $custom->has_length;
        }

        $def = self::definitions()[$braidType] ?? null;
        if ($def) {
            $row = self::cardPrices()[$braidType] ?? null;
            if ($row && array_key_exists('has_length', $row) && $row['has_length'] !== null) {
                return (bool) $row['has_length'];
            }

            return empty($def['disable_steps']);
        }

        return true;
    }

    public static function displayName(?string $braidType): ?string
    {
        if (!$braidType) {
            return null;
        }

        $overrides = (array) SiteSettings::get('kids_styles', []);
        $defaultLabel = trim((string) (SiteSettings::defaultKidsStyles()[$braidType]['label'] ?? ''));
        $overrideLabel = trim((string) ($overrides[$braidType]['label'] ?? ''));
        if ($overrideLabel !== '' && strcasecmp($overrideLabel, $defaultLabel) !== 0) {
            return $overrideLabel;
        }

        $cmsName = trim((string) (self::cardPrices()[$braidType]['name'] ?? ''));
        if ($cmsName !== '') {
            return $cmsName;
        }

        $friendly = [
            'protective' => 'Natural Hair Twist',
            'cornrows' => 'Cornrow (without extension)',
            'cornrow_weave' => 'Cornrow weave (with extension)',
            'knotless_small' => 'Knotless Small',
            'knotless_med' => 'Knotless Medium',
            'box_small' => 'Box Braids Small',
            'box_med' => 'Box Braids Medium',
            'stitch' => 'Stitch Braids',
            'half_weave_braid' => '1/2 Weave & 1/2 Braid',
            'half_weave_crotchet' => '1/2 Weave & 1/2 Crotchet',
            'crotchet_style' => 'Crotchet Style',
        ];
        if (isset($friendly[$braidType])) {
            return $friendly[$braidType];
        }

        $custom = self::resolveCustom($braidType);
        if ($custom) {
            return $custom->name;
        }

        return ucwords(str_replace(['_', '-'], ' ', $braidType));
    }

    /**
     * Ordered, visible kids selector cards for the booking UI.
     *
     * @return list<array{key:string,label:string,price:int,disable_steps:bool,from_price:bool,image:string,duration:string,blurb:string}>
     */
    public static function selectorCards(): array
    {
        $prices = self::cardPrices();
        $overrides = (array) SiteSettings::get('kids_styles', []);
        $rows = [];
        $index = 0;
        foreach (self::definitions() as $key => $def) {
            $cms = $prices[$key] ?? [];
            if (! empty($cms['from_cms']) && array_key_exists('is_active', $cms) && ! $cms['is_active']) {
                continue;
            }
            $row = $overrides[$key] ?? [];
            if (array_key_exists('visible', $row) && ! $row['visible']) {
                continue;
            }
            $price = (int) ($cms['price'] ?? $def['default_price']);
            $cmsImage = trim((string) ($cms['image_url'] ?? ''));
            $cmsDuration = trim((string) ($cms['duration'] ?? ''));
            $image = AdultServiceCatalog::usableImageUrl($cmsImage);
            if ($image === '') {
                $image = AdultServiceCatalog::publicImageUrl((string) ($def['image'] ?? ''));
            }
            $hasLength = array_key_exists('has_length', $cms) && $cms['has_length'] !== null
                ? (bool) $cms['has_length']
                : empty($def['disable_steps']);
            $rows[] = [
                'key' => $key,
                'label' => self::displayName($key) ?: $def['name'],
                'price' => $price,
                'disable_steps' => ! $hasLength,
                'from_price' => $hasLength,
                'image' => $image,
                'duration' => $cmsDuration !== '' ? $cmsDuration : (string) ($def['duration'] ?? ''),
                'blurb' => self::usableBlurb($cms['description'] ?? '', (string) ($def['blurb'] ?? '')),
                'sort' => (int) ($row['sort'] ?? (($index + 1) * 10)),
                'discount_ends' => (string) ($cms['discount_ends'] ?? ''),
            ];
            $index++;
        }

        try {
            foreach (self::customServices() as $svc) {
                $key = 'cms_'.$svc->id;
                $row = $overrides[$key] ?? [];
                if (array_key_exists('visible', $row) && ! $row['visible']) {
                    continue;
                }
                $hasLength = ! isset($svc->has_length) || (bool) $svc->has_length;
                $rows[] = [
                    'key' => $key,
                    'label' => (string) $svc->name,
                    'price' => (int) $svc->effective_price,
                    'disable_steps' => ! $hasLength,
                    'from_price' => $hasLength,
                    'image' => AdultServiceCatalog::usableImageUrl($svc->image_url ?? ''),
                    'duration' => (string) ($svc->duration ?? ''),
                    'blurb' => self::usableBlurb($svc->description ?? '', ''),
                    'sort' => (int) ($row['sort'] ?? (($index + 1) * 10)),
                    'discount_ends' => ($svc->has_discount && $svc->discount_ends_at)
                        ? $svc->discount_ends_at->toIso8601String()
                        : '',
                ];
                $index++;
            }
        } catch (\Throwable $e) {
            // Built-in cards still show if extra CMS styles cannot be loaded.
        }

        usort($rows, fn ($a, $b) => $a['sort'] <=> $b['sort']);

        return $rows;
    }

    /** Lowest visible kids selector price for the homepage card. */
    public static function lowestVisiblePrice(): int
    {
        $min = null;
        foreach (self::selectorCards() as $card) {
            $price = (int) ($card['price'] ?? 0);
            if ($price <= 0) {
                continue;
            }
            if ($min === null || $price < $min) {
                $min = $price;
            }
        }

        return $min ?? (int) config('service_prices.kids_braids', 40);
    }

    /**
     * Style labels, photos, and times for the kids booking modal recap.
     *
     * @return array<string, array{label:string,image:string,duration:string,blurb:string,price:int,disable_steps:bool}>
     */
    public static function publicMeta(): array
    {
        $out = [];
        foreach (self::selectorCards() as $card) {
            $out[$card['key']] = [
                'label' => $card['label'],
                'image' => $card['image'],
                'duration' => $card['duration'],
                'blurb' => $card['blurb'],
                'price' => $card['price'],
                'disable_steps' => ! empty($card['disable_steps']),
            ];
        }

        try {
            foreach (self::customServices() as $svc) {
                $key = 'cms_'.$svc->id;
                $out[$key] = [
                    'label' => (string) $svc->name,
                    'image' => AdultServiceCatalog::usableImageUrl($svc->image_url ?? ''),
                    'duration' => (string) ($svc->duration ?? ''),
                    'blurb' => trim((string) ($svc->description ?? '')),
                    'price' => (int) $svc->effective_price,
                    'disable_steps' => isset($svc->has_length) && ! (bool) $svc->has_length,
                ];
            }
        } catch (\Throwable $e) {
            // Keep built-in styles when custom services cannot be loaded.
        }

        return $out;
    }
}
