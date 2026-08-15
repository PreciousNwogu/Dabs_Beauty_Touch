<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class SiteSettings
{
    public const CACHE_KEY = 'site_settings.all';

    public static function defaults(): array
    {
        return [
            'interac_email' => (string) config('services.interac.email', 'dabereprecious01@gmail.com'),
            'interac_amount' => (float) config('services.interac.amount', 20),
            'max_bookings_per_day' => 2,
            'finished_tip_amount' => 20.0,
            'front_back_amount' => 20.0,
            'length_adjustments' => [
                'neck' => -40,
                'shoulder' => -40,
                'armpit' => -40,
                'bra_strap' => 0,
                'mid_back' => 0,
                'waist' => 20,
                'hip' => 40,
                'tailbone' => 60,
                'classic' => 60,
            ],
            'categories' => self::defaultCategories(),
            'kids_styles' => self::defaultKidsStyles(),
            'hero_image' => '',
            'promo_image' => '',
            'promo_title' => '',
            'promo_text' => '',
            'promo_enabled' => false,
        ];
    }

    public static function defaultCategories(): array
    {
        $order = 10;
        $out = [];
        foreach (AdultServiceCatalog::categories() as $key => $label) {
            $out[$key] = [
                'label' => $label,
                'visible' => true,
                'sort' => $order,
            ];
            $order += 10;
        }
        $out['kids'] = [
            'label' => 'Kids Braids',
            'visible' => true,
            'sort' => $order,
        ];
        $out['boho'] = [
            'label' => 'Boho Braids',
            'visible' => true,
            'sort' => 15,
        ];

        return $out;
    }

    public static function defaultKidsStyles(): array
    {
        $order = 10;
        $out = [];
        foreach (KidsStyleCatalog::definitions() as $key => $def) {
            $out[$key] = [
                'label' => $def['name'],
                'visible' => true,
                'sort' => $order,
            ];
            $order += 10;
        }

        return $out;
    }

    public static function all(): array
    {
        $defaults = self::defaults();

        try {
            if (! Schema::hasTable('site_settings')) {
                return $defaults;
            }
        } catch (\Throwable $e) {
            return $defaults;
        }

        return Cache::remember(self::CACHE_KEY, 300, function () use ($defaults) {
            $stored = [];
            try {
                foreach (SiteSetting::query()->get() as $row) {
                    $stored[$row->key] = $row->value;
                }
            } catch (\Throwable $e) {
                return $defaults;
            }

            $merged = $defaults;
            foreach ($defaults as $key => $default) {
                if (! array_key_exists($key, $stored)) {
                    continue;
                }
                $value = $stored[$key];
                if (is_array($default) && is_array($value)) {
                    $merged[$key] = array_replace_recursive($default, $value);
                } else {
                    $merged[$key] = $value;
                }
            }

            return $merged;
        });
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $all = self::all();
        if (array_key_exists($key, $all)) {
            return $all[$key];
        }

        return $default;
    }

    public static function put(string $key, mixed $value): void
    {
        SiteSetting::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
        Cache::forget(self::CACHE_KEY);
    }

    public static function putMany(array $pairs): void
    {
        foreach ($pairs as $key => $value) {
            SiteSetting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        Cache::forget(self::CACHE_KEY);
    }

    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    public static function maxBookingsPerDay(): int
    {
        return max(1, min(10, (int) self::get('max_bookings_per_day', 2)));
    }

    public static function lengthAdjustments(): array
    {
        $map = self::get('length_adjustments', []);
        $out = [];
        foreach ((array) $map as $length => $amount) {
            $out[(string) $length] = (float) $amount;
        }

        return $out;
    }

    public static function finishedTipAmount(): float
    {
        return (float) self::get('finished_tip_amount', 20);
    }

    public static function frontBackAmount(): float
    {
        return (float) self::get('front_back_amount', 20);
    }

    /**
     * @return list<array{key:string,label:string,visible:bool,sort:int}>
     */
    public static function categoryCards(): array
    {
        $raw = (array) self::get('categories', self::defaultCategories());
        $rows = [];
        foreach ($raw as $key => $row) {
            $rows[] = [
                'key' => (string) $key,
                'label' => (string) ($row['label'] ?? $key),
                'visible' => (bool) ($row['visible'] ?? true),
                'sort' => (int) ($row['sort'] ?? 100),
            ];
        }
        usort($rows, fn ($a, $b) => $a['sort'] <=> $b['sort']);

        return $rows;
    }

    public static function categoryLabel(string $key, ?string $fallback = null): string
    {
        $raw = (array) self::get('categories', []);
        if (isset($raw[$key]['label']) && trim((string) $raw[$key]['label']) !== '') {
            return (string) $raw[$key]['label'];
        }

        return $fallback ?? (AdultServiceCatalog::categories()[$key] ?? $key);
    }

    public static function categoryVisible(string $key): bool
    {
        $raw = (array) self::get('categories', []);
        if (! array_key_exists($key, $raw)) {
            return true;
        }

        return (bool) ($raw[$key]['visible'] ?? true);
    }

    public static function categorySort(string $key): int
    {
        $raw = (array) self::get('categories', []);

        return (int) ($raw[$key]['sort'] ?? 100);
    }

    public static function heroImageUrl(): string
    {
        $path = trim((string) self::get('hero_image', ''));
        if ($path === '') {
            return asset('images/backgroundbraid.jpg');
        }

        $url = AdultServiceCatalog::publicImageUrl(
            str_starts_with($path, 'http') || str_starts_with($path, '/')
                ? $path
                : '/storage/'.ltrim($path, '/')
        );

        return $url !== '' ? $url : asset('images/backgroundbraid.jpg');
    }

    public static function promoImageUrl(): string
    {
        $path = trim((string) self::get('promo_image', ''));
        if ($path === '') {
            return '';
        }

        return AdultServiceCatalog::publicImageUrl(
            str_starts_with($path, 'http') || str_starts_with($path, '/')
                ? $path
                : '/storage/'.ltrim($path, '/')
        );
    }
}
