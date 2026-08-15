<?php

namespace App\Support;

class InteracDeposit
{
    public static function email(): string
    {
        return (string) config('services.interac.email', 'dabereprecious01@gmail.com');
    }

    public static function amount(): float
    {
        return (float) config('services.interac.amount', 20);
    }

    public static function amountLabel(): string
    {
        return '$'.number_format(self::amount(), 2);
    }
}
