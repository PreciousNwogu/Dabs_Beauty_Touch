<?php

namespace App\Support;

use App\Models\Service;

class KidsStyleCatalog
{
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
            ],
            'cornrows' => [
                'slug' => 'cornrows',
                'alt_slugs' => ['kids-cornrows'],
                'name' => 'Kids Cornrows',
                'default_price' => 40,
                'disable_steps' => true,
                'fallback_adj' => -40,
            ],
            'cornrow_weave' => [
                'slug' => 'cornrow_weave',
                'alt_slugs' => ['kids-cornrow-weave'],
                'name' => 'Kids Cornrow Weave',
                'default_price' => 100,
                'disable_steps' => false,
                'fallback_adj' => 0,
            ],
            'knotless_small' => [
                'slug' => 'knotless_small',
                'alt_slugs' => ['kids-knotless-small'],
                'name' => 'Kids Knotless Small',
                'default_price' => 120,
                'disable_steps' => false,
                'fallback_adj' => 20,
            ],
            'knotless_med' => [
                'slug' => 'knotless_med',
                'alt_slugs' => ['kids-knotless-medium', 'kids-knotless-med'],
                'name' => 'Kids Knotless Medium',
                'default_price' => 100,
                'disable_steps' => false,
                'fallback_adj' => 0,
            ],
            'box_small' => [
                'slug' => 'box_small',
                'alt_slugs' => ['kids-box-small'],
                'name' => 'Kids Box Braids Small',
                'default_price' => 110,
                'disable_steps' => false,
                'fallback_adj' => 10,
            ],
            'box_med' => [
                'slug' => 'box_med',
                'alt_slugs' => ['kids-box-medium', 'kids-box-med'],
                'name' => 'Kids Box Braids Medium',
                'default_price' => 100,
                'disable_steps' => false,
                'fallback_adj' => 0,
            ],
            'stitch' => [
                'slug' => 'stitch',
                'alt_slugs' => ['kids-stitch', 'kids-stitch-braids'],
                'name' => 'Kids Stitch Braids',
                'default_price' => 120,
                'disable_steps' => false,
                'fallback_adj' => 20,
            ],
            'half_weave_braid' => [
                'slug' => 'half_weave_braid',
                'alt_slugs' => ['kids-half-weave-braid'],
                'name' => 'Kids 1/2 Weave & 1/2 Braid',
                'default_price' => 120,
                'disable_steps' => false,
                'fallback_adj' => 0,
            ],
            'half_weave_crotchet' => [
                'slug' => 'half_weave_crotchet',
                'alt_slugs' => ['kids-half-weave-crotchet'],
                'name' => 'Kids 1/2 Weave & 1/2 Crotchet',
                'default_price' => 100,
                'disable_steps' => true,
                'fallback_adj' => 0,
            ],
            'crotchet_style' => [
                'slug' => 'crotchet_style',
                'alt_slugs' => ['kids-crotchet-style'],
                'name' => 'Kids Crotchet Style',
                'default_price' => 90,
                'disable_steps' => true,
                'fallback_adj' => 0,
            ],
        ];
    }

    public static function slugs(): array
    {
        $slugs = [];
        foreach (self::definitions() as $def) {
            $slugs[] = $def['slug'];
            foreach ($def['alt_slugs'] ?? [] as $alt) {
                $slugs[] = $alt;
            }
        }

        return array_values(array_unique($slugs));
    }

    public static function isCatalogSlug(?string $slug): bool
    {
        return $slug && in_array($slug, self::slugs(), true);
    }

    /**
     * @return array<string, array{price:int, original:int, slug:string, from_cms:bool}>
     */
    public static function cardPrices(): array
    {
        static $cached = null;
        if ($cached !== null) {
            return $cached;
        }

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
            ];
        }

        return $cached = $out;
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
        if (isset($overrides[$braidType]['label']) && trim((string) $overrides[$braidType]['label']) !== '') {
            return (string) $overrides[$braidType]['label'];
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
     * @return list<array{key:string,label:string,price:int,disable_steps:bool,from_price:bool}>
     */
    public static function selectorCards(): array
    {
        $prices = self::cardPrices();
        $overrides = (array) SiteSettings::get('kids_styles', []);
        $rows = [];
        $index = 0;
        foreach (self::definitions() as $key => $def) {
            $row = $overrides[$key] ?? [];
            if (array_key_exists('visible', $row) && ! $row['visible']) {
                continue;
            }
            $price = (int) ($prices[$key]['price'] ?? $def['default_price']);
            $rows[] = [
                'key' => $key,
                'label' => self::displayName($key) ?: $def['name'],
                'price' => $price,
                'disable_steps' => ! empty($def['disable_steps']),
                'from_price' => empty($def['disable_steps']),
                'sort' => (int) ($row['sort'] ?? (($index + 1) * 10)),
            ];
            $index++;
        }
        usort($rows, fn ($a, $b) => $a['sort'] <=> $b['sort']);

        return $rows;
    }
}
