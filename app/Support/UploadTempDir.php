<?php

namespace App\Support;

class UploadTempDir
{
    public static function ensure(): string
    {
        $path = storage_path('app/tmp');
        if (! is_dir($path)) {
            @mkdir($path, 0775, true);
        }

        if (! is_dir($path) || ! is_writable($path)) {
            $fallback = rtrim((string) (getenv('LOCALAPPDATA') ?: getenv('TEMP') ?: sys_get_temp_dir()), '\\/');
            $path = $fallback !== '' ? $fallback : $path;
            if (! is_dir($path)) {
                @mkdir($path, 0775, true);
            }
        }

        return str_replace('\\', '/', $path);
    }
}
