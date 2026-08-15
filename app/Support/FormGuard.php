<?php

namespace App\Support;

use Illuminate\Http\Request;

class FormGuard
{
    public static function isBot(Request $request): bool
    {
        return filled($request->input('company_website'));
    }
}
