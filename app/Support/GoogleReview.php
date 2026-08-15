<?php

namespace App\Support;

class GoogleReview
{
    public static function url(): string
    {
        $direct = trim((string) config('services.google.review_url'));
        if ($direct !== '') {
            return $direct;
        }

        $placeId = trim((string) config('services.google.place_id'));
        if ($placeId !== '') {
            return 'https://search.google.com/local/writereview?placeid=' . urlencode($placeId);
        }

        return 'https://www.google.com/search?q=' . rawurlencode("Dabs Beauty Touch Ottawa");
    }
}
