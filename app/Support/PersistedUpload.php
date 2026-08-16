<?php

namespace App\Support;

use App\Models\Service;
use App\Models\StoredImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class PersistedUpload
{
    private const OWNED_PREFIXES = [
        '/images/uploads/',
        '/images/site/',
        '/images/services/',
        '/storage/service-images/',
        '/storage/site/',
    ];

    public static function normalize(?string $path): string
    {
        $path = trim(str_replace('\\', '/', (string) $path));
        if ($path === '') {
            return '';
        }
        if (preg_match('#^https?://#i', $path)) {
            $parsed = parse_url($path, PHP_URL_PATH);
            $path = is_string($parsed) ? $parsed : '';
        }

        $path = '/'.ltrim($path, '/');
        $parts = explode('/', $path);
        $file = rawurldecode(str_replace('+', ' ', (string) array_pop($parts)));
        $parts[] = $file;

        return implode('/', $parts);
    }

    public static function isSafePublicPath(string $path): bool
    {
        $path = self::normalize($path);
        if ($path === '/' || str_contains($path, '..')) {
            return false;
        }

        return str_starts_with($path, '/images/') || str_starts_with($path, '/storage/');
    }

    public static function absolutePath(string $path): string
    {
        $path = ltrim(self::normalize($path), '/');
        if (str_starts_with($path, 'storage/')) {
            return storage_path('app/public/'.substr($path, strlen('storage/')));
        }

        return public_path($path);
    }

    public static function put(string $publicPath, string $binary, ?string $mime = null): string
    {
        $publicPath = self::normalize($publicPath);
        if (! self::isSafePublicPath($publicPath) || $binary === '') {
            throw new \InvalidArgumentException('That image path cannot be saved.');
        }

        $absolute = self::absolutePath($publicPath);
        File::ensureDirectoryExists(dirname($absolute));
        file_put_contents($absolute, $binary);

        self::remember($publicPath, $absolute, $binary, $mime);

        return $publicPath;
    }

    public static function putFile(string $publicPath, string $sourcePath, ?string $mime = null): string
    {
        $publicPath = self::normalize($publicPath);
        if (! self::isSafePublicPath($publicPath) || ! is_file($sourcePath)) {
            throw new \InvalidArgumentException('That file cannot be saved.');
        }

        $absolute = self::absolutePath($publicPath);
        File::ensureDirectoryExists(dirname($absolute));
        if (! @copy($sourcePath, $absolute) || ! is_file($absolute)) {
            throw new \RuntimeException('Could not copy the uploaded file.');
        }

        $size = filesize($absolute);
        $binary = '';
        if ($size !== false && $size <= 4 * 1024 * 1024) {
            $binary = (string) file_get_contents($absolute);
        }
        self::remember($publicPath, $absolute, $binary, $mime, $size !== false && $size > 4 * 1024 * 1024);

        return $publicPath;
    }

    public static function storeUpload(string $prefix, string $binary, string $ext, ?string $mime = null): string
    {
        $ext = strtolower($ext === 'jpeg' ? 'jpg' : $ext);
        if (! in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif', 'mp4', 'webm', 'mov', 'm4v'], true)) {
            $ext = 'jpg';
        }

        $name = $prefix.'-'.substr(uniqid('', true), -8).'.'.$ext;
        $folder = $prefix === 'hero' || $prefix === 'promo' ? 'site' : 'uploads';

        return self::put('/images/'.$folder.'/'.$name, $binary, $mime);
    }

    public static function persistExisting(?string $publicPath): ?string
    {
        try {
            $publicPath = self::normalize($publicPath);
            if ($publicPath === '' || ! self::isSafePublicPath($publicPath)) {
                return null;
            }

            $absolute = self::absolutePath($publicPath);
            if (! is_file($absolute)) {
                return self::hasStored($publicPath) ? $publicPath : null;
            }

            $size = filesize($absolute);
            if ($size !== false && $size > 4 * 1024 * 1024) {
                return $publicPath;
            }

            $binary = file_get_contents($absolute);
            if ($binary === false || $binary === '') {
                return null;
            }

            self::put($publicPath, $binary, mime_content_type($absolute) ?: null);

            return $publicPath;
        } catch (\Throwable $e) {
            return null;
        }
    }

    public static function isAvailable(?string $publicPath): bool
    {
        $publicPath = self::normalize($publicPath);
        if ($publicPath === '' || ! self::isSafePublicPath($publicPath)) {
            return false;
        }

        if (is_file(self::absolutePath($publicPath))) {
            return true;
        }

        return self::hasStored($publicPath);
    }

    public static function restoreOne(string $publicPath): bool
    {
        $publicPath = self::normalize($publicPath);
        if (! Schema::hasTable('stored_images')) {
            return false;
        }

        $row = StoredImage::query()->where('public_path', $publicPath)->first();
        if (! $row) {
            return false;
        }

        return self::writeRow($row);
    }

    public static function restoreAll(): int
    {
        if (! Schema::hasTable('stored_images')) {
            return 0;
        }

        $count = 0;
        foreach (StoredImage::query()->cursor() as $row) {
            if (self::writeRow($row)) {
                $count++;
            }
        }

        return $count;
    }

    public static function captureReferenced(): int
    {
        $paths = [];
        if (Schema::hasColumn('services', 'image_url')) {
            $paths = array_merge($paths, Service::query()
                ->whereNotNull('image_url')
                ->where('image_url', '!=', '')
                ->pluck('image_url')
                ->all());
        }

        try {
            foreach (['hero_image', 'promo_image'] as $key) {
                $value = (string) SiteSettings::get($key, '');
                if ($value !== '') {
                    $paths[] = $value;
                }
            }
            foreach (SiteSettings::promoMedia() as $item) {
                $value = (string) ($item['path'] ?? '');
                if ($value !== '') {
                    $paths[] = $value;
                }
            }
        } catch (\Throwable $e) {
            // Settings table may not exist yet during early migrate.
        }

        $count = 0;
        foreach (array_unique($paths) as $path) {
            if (self::persistExisting((string) $path)) {
                $count++;
            }
        }

        return $count;
    }

    public static function forget(?string $publicPath): void
    {
        $publicPath = self::normalize($publicPath);
        if ($publicPath === '' || ! self::isOwned($publicPath)) {
            return;
        }

        $absolute = self::absolutePath($publicPath);
        if (is_file($absolute)) {
            @unlink($absolute);
        }

        if (Schema::hasTable('stored_images')) {
            StoredImage::query()->where('public_path', $publicPath)->delete();
        }
    }

    public static function isOwned(string $path): bool
    {
        $path = self::normalize($path);
        foreach (self::OWNED_PREFIXES as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return true;
            }
        }

        return false;
    }

    private static function remember(string $publicPath, string $absolute, string $binary, ?string $mime, bool $skipContents = false): void
    {
        if (! Schema::hasTable('stored_images')) {
            return;
        }

        StoredImage::query()->updateOrCreate(
            ['public_path' => $publicPath],
            [
                'mime' => $mime ?: (is_file($absolute) ? (mime_content_type($absolute) ?: 'image/jpeg') : 'image/jpeg'),
                'contents' => ($skipContents || $binary === '') ? '' : base64_encode($binary),
            ]
        );
    }

    private static function hasStored(string $publicPath): bool
    {
        if (! Schema::hasTable('stored_images')) {
            return false;
        }

        return StoredImage::query()->where('public_path', $publicPath)->exists();
    }

    private static function writeRow(StoredImage $row): bool
    {
        $publicPath = self::normalize((string) $row->public_path);
        $binary = base64_decode((string) $row->contents, true);
        if ($publicPath === '' || $binary === false || $binary === '') {
            return false;
        }

        $absolute = self::absolutePath($publicPath);
        File::ensureDirectoryExists(dirname($absolute));

        return file_put_contents($absolute, $binary) !== false;
    }
}
