<?php

namespace App\Support;

use Illuminate\Http\Request;

class BookingReturn
{
    public static function routeName(Request $request): string
    {
        return $request->input('booking_origin') === 'kids-selector'
            ? 'kids.selector'
            : 'home';
    }

    public static function composeKidsMessage(Request $request): ?string
    {
        $lines = [];
        $existing = trim((string) $request->input('message', ''));
        if ($existing !== '') {
            $lines[] = $existing;
        }
        if ($request->filled('parent_name')) {
            $lines[] = 'Parent/Guardian: '.trim((string) $request->input('parent_name'));
        }
        if ($request->filled('child_age')) {
            $lines[] = 'Child age: '.trim((string) $request->input('child_age'));
        }
        if ($request->filled('hair_color')) {
            $lines[] = 'Hair color preference: '.trim((string) $request->input('hair_color'));
        }
        $comments = trim((string) ($request->input('comments') ?: $request->input('kb_comments') ?: ''));
        if ($comments !== '' && $comments !== $existing) {
            $lines[] = $comments;
        }
        $out = trim(implode("\n", array_filter($lines)));

        return $out !== '' ? mb_substr($out, 0, 1000) : null;
    }
}
