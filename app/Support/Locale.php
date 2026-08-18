<?php

namespace App\Support;

class Locale
{
    public const AVAILABLE = ['en', 'fr'];

    public const SESSION_KEY = 'locale';

    public const COOKIE = 'locale';

    public static function isSupported(?string $locale): bool
    {
        return is_string($locale) && in_array($locale, self::AVAILABLE, true);
    }

    public static function openGraph(?string $locale = null): string
    {
        return ($locale ?? app()->getLocale()) === 'fr' ? 'fr_CA' : 'en_CA';
    }
}
