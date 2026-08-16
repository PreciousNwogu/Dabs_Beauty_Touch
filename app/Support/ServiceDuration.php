<?php

namespace App\Support;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Support\Facades\Schema;

class ServiceDuration
{
    public const DEFAULT_HOURS = 4.0;

    public const KIDS_DEFAULT_HOURS = 3.0;

    public const MIN_HOURS = 1.0;

    public const MAX_HOURS = 12.0;

    public static function parseToHours(?string $raw): float
    {
        if ($raw === null) {
            return self::DEFAULT_HOURS;
        }

        $raw = strtolower(str_replace(['–', '—'], '-', trim($raw)));
        if ($raw === '') {
            return self::DEFAULT_HOURS;
        }

        if (! preg_match_all('/(\d+(?:\.\d+)?)/', $raw, $matches) || empty($matches[1])) {
            return self::DEFAULT_HOURS;
        }

        $value = max(array_map('floatval', $matches[1]));

        if (str_contains($raw, 'min')) {
            $value = $value / 60;
        }

        return self::normalizeHours($value);
    }

    public static function normalizeHours(mixed $hours): float
    {
        $hours = (float) $hours;
        if ($hours <= 0) {
            return self::DEFAULT_HOURS;
        }

        return max(self::MIN_HOURS, min(self::MAX_HOURS, $hours));
    }

    public static function hoursForName(?string $name): float
    {
        $name = trim((string) $name);
        if ($name === '') {
            return self::DEFAULT_HOURS;
        }

        $service = self::findService($name);
        if ($service && filled($service->duration)) {
            return self::parseToHours($service->duration);
        }

        if ($service && ! empty($service->for_kids)) {
            return self::KIDS_DEFAULT_HOURS;
        }

        if (stripos($name, 'kids') !== false) {
            return self::KIDS_DEFAULT_HOURS;
        }

        return self::DEFAULT_HOURS;
    }

    public static function hoursForRequest(?string $serviceName, mixed $requestedHours = null): float
    {
        if (filled($serviceName)) {
            return self::hoursForName($serviceName);
        }

        if ($requestedHours !== null && $requestedHours !== '') {
            return self::normalizeHours($requestedHours);
        }

        return self::DEFAULT_HOURS;
    }

    public static function toMinutes(float $hours): int
    {
        return (int) round($hours * 60);
    }

    public static function minutesForBooking(Booking $booking): int
    {
        $stored = (int) ($booking->service_duration_minutes ?? 0);
        if ($stored > 0) {
            return $stored;
        }

        return self::toMinutes(self::hoursForName($booking->service));
    }

    public static function extraMinutesForKidsExtras(mixed $extras): int
    {
        $raw = is_array($extras) ? implode(',', $extras) : (string) $extras;

        return str_contains($raw, 'kb_add_rest') ? 15 : 0;
    }

    /**
     * @return array<string, float>
     */
    public static function hoursByServiceName(): array
    {
        if (! Schema::hasTable('services')) {
            return [];
        }

        $query = Service::query();
        if (Schema::hasColumn('services', 'is_active')) {
            $query->where('is_active', true);
        }

        $map = [];
        foreach ($query->get(['name', 'duration', 'for_kids']) as $service) {
            if (filled($service->duration)) {
                $map[$service->name] = self::parseToHours($service->duration);
            } elseif (! empty($service->for_kids)) {
                $map[$service->name] = self::KIDS_DEFAULT_HOURS;
            } else {
                $map[$service->name] = self::DEFAULT_HOURS;
            }
        }

        return $map;
    }

    private static function findService(string $name): ?Service
    {
        if (! Schema::hasTable('services')) {
            return null;
        }

        return Service::query()
            ->where(function ($query) use ($name) {
                $query->where('name', $name)
                    ->orWhere('slug', $name)
                    ->orWhereRaw('LOWER(name) = ?', [strtolower($name)]);
            })
            ->first();
    }
}
