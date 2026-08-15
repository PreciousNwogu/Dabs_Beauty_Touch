<?php

namespace App\Support;

class InteracDeposit
{
    public static function email(): string
    {
        $fromCms = trim((string) SiteSettings::get('interac_email', ''));
        if ($fromCms !== '') {
            return $fromCms;
        }

        return (string) config('services.interac.email', 'dabereprecious01@gmail.com');
    }

    public static function amount(): float
    {
        $fromCms = SiteSettings::get('interac_amount', null);
        if ($fromCms !== null && $fromCms !== '') {
            return (float) $fromCms;
        }

        return (float) config('services.interac.amount', 20);
    }

    public static function amountLabel(): string
    {
        return '$'.number_format(self::amount(), 2);
    }
}
