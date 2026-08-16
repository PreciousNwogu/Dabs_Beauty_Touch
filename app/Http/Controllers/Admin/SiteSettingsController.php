<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdultServiceCatalog;
use App\Support\KidsStyleCatalog;
use App\Support\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;

class SiteSettingsController extends Controller
{
    private const PROMO_FILE_MAX_KB = 102400;

    public function edit()
    {
        $settings = SiteSettings::all();
        $categories = SiteSettings::categoryCards();
        $kidsStyles = [];
        $kidsRaw = (array) ($settings['kids_styles'] ?? []);
        foreach (KidsStyleCatalog::definitions() as $key => $def) {
            $row = $kidsRaw[$key] ?? [];
            $kidsStyles[] = [
                'key' => $key,
                'label' => (string) ($row['label'] ?? $def['name']),
                'visible' => (bool) ($row['visible'] ?? true),
                'sort' => (int) ($row['sort'] ?? 100),
            ];
        }
        usort($kidsStyles, fn ($a, $b) => $a['sort'] <=> $b['sort']);

        $knownKeys = array_merge(array_keys(AdultServiceCatalog::categories()), ['kids', 'boho']);
        foreach ($knownKeys as $key) {
            if (! collect($categories)->contains(fn ($c) => $c['key'] === $key)) {
                $categories[] = [
                    'key' => $key,
                    'label' => SiteSettings::categoryLabel($key),
                    'visible' => true,
                    'sort' => 200,
                ];
            }
        }
        usort($categories, fn ($a, $b) => $a['sort'] <=> $b['sort']);

        return view('admin.settings.edit', compact('settings', 'categories', 'kidsStyles'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'interac_email' => 'required|email|max:255',
            'interac_amount' => 'required|numeric|min:0|max:999',
            'max_bookings_per_day' => 'required|integer|min:1|max:10',
            'finished_tip_amount' => 'required|numeric|min:0|max:500',
            'front_back_amount' => 'required|numeric|min:0|max:500',
            'length' => 'nullable|array',
            'length.*' => 'nullable|numeric|min:-200|max:500',
            'category' => 'nullable|array',
            'category.*.label' => 'nullable|string|max:100',
            'category.*.visible' => 'nullable|boolean',
            'category.*.sort' => 'nullable|integer|min:0|max:9999',
            'kids' => 'nullable|array',
            'kids.*.label' => 'nullable|string|max:100',
            'kids.*.visible' => 'nullable|boolean',
            'kids.*.sort' => 'nullable|integer|min:0|max:9999',
            'promo_enabled' => 'nullable|boolean',
            'promo_title' => 'nullable|string|max:120',
            'promo_text' => 'nullable|string|max:500',
            'hero_image_data' => 'nullable|string',
            'promo_image_data' => 'nullable|string',
            'hero_image' => 'nullable|file|max:10240',
            'promo_image' => 'nullable|file|max:'.self::PROMO_FILE_MAX_KB,
            'promo_files' => 'nullable|array|max:12',
            'promo_files.*' => $this->promoFileRules(),
            'remove_hero_image' => 'nullable|boolean',
            'remove_promo_image' => 'nullable|boolean',
            'remove_promo_media' => 'nullable|array',
            'remove_promo_media.*' => 'nullable|string|max:400',
        ], [
            'hero_image.max' => 'The hero image must be 10 MB or smaller.',
            'promo_image.max' => 'Each promo photo or video must be 100 MB or smaller.',
            'promo_files.*.uploaded' => 'That photo or video could not be received. Use a shorter MP4 or WEBM clip under 100 MB.',
            'promo_files.*.max' => 'Each promo photo or video must be 100 MB or smaller.',
        ]);

        $lengthDefaults = SiteSettings::defaults()['length_adjustments'];
        $lengthMap = [];
        foreach ($lengthDefaults as $key => $default) {
            $lengthMap[$key] = isset($data['length'][$key]) && $data['length'][$key] !== null
                ? (float) $data['length'][$key]
                : (float) $default;
        }

        $categories = SiteSettings::defaultCategories();
        foreach ((array) ($data['category'] ?? []) as $key => $row) {
            $categories[$key] = [
                'label' => trim((string) ($row['label'] ?? ($categories[$key]['label'] ?? $key))) ?: ($categories[$key]['label'] ?? $key),
                'visible' => ! empty($row['visible']),
                'sort' => (int) ($row['sort'] ?? ($categories[$key]['sort'] ?? 100)),
            ];
        }

        $kids = SiteSettings::defaultKidsStyles();
        foreach ((array) ($data['kids'] ?? []) as $key => $row) {
            $kids[$key] = [
                'label' => trim((string) ($row['label'] ?? ($kids[$key]['label'] ?? $key))) ?: ($kids[$key]['label'] ?? $key),
                'visible' => ! empty($row['visible']),
                'sort' => (int) ($row['sort'] ?? ($kids[$key]['sort'] ?? 100)),
            ];
        }

        $heroPath = (string) SiteSettings::get('hero_image', '');
        if ($request->boolean('remove_hero_image')) {
            $this->deleteStoredImage($heroPath);
            $heroPath = '';
        }
        $heroStored = $this->resolveSiteImage($request, 'hero_image', 'hero_image_data', 'hero');
        if ($heroStored !== null) {
            $this->deleteStoredImage($heroPath);
            $heroPath = $heroStored;
        }

        $promoMedia = $this->syncPromoMedia($request);

        SiteSettings::putMany([
            'interac_email' => $data['interac_email'],
            'interac_amount' => (float) $data['interac_amount'],
            'max_bookings_per_day' => (int) $data['max_bookings_per_day'],
            'finished_tip_amount' => (float) $data['finished_tip_amount'],
            'front_back_amount' => (float) $data['front_back_amount'],
            'length_adjustments' => $lengthMap,
            'categories' => $categories,
            'kids_styles' => $kids,
            'hero_image' => $heroPath,
            'promo_image' => $this->firstPromoImagePath($promoMedia),
            'promo_media' => array_map(fn ($item) => [
                'path' => $item['path'],
                'type' => $item['type'],
            ], $promoMedia),
            'promo_title' => trim((string) ($data['promo_title'] ?? '')),
            'promo_text' => trim((string) ($data['promo_text'] ?? '')),
            'promo_enabled' => $request->boolean('promo_enabled'),
        ]);

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Business settings saved.');
    }

    private function resolveSiteImage(Request $request, string $fileField, string $dataField, string $prefix): ?string
    {
        $fromData = $this->storeImageDataUrl($request->input($dataField), $prefix, $dataField);
        if ($fromData !== null) {
            return $fromData;
        }

        if (! $request->hasFile($fileField)) {
            return null;
        }

        $file = $request->file($fileField);
        if (! $file instanceof UploadedFile || ! $file->isValid()) {
            // Temp-dir failures often leave an invalid upload; ignore if no data URL was sent.
            if ($file instanceof UploadedFile && in_array($file->getError(), [UPLOAD_ERR_NO_TMP_DIR, UPLOAD_ERR_CANT_WRITE, UPLOAD_ERR_NO_FILE], true)) {
                return null;
            }

            throw ValidationException::withMessages([
                $fileField => $file instanceof UploadedFile
                    ? $this->describeUploadError($file)
                    : 'The image could not be uploaded.',
            ]);
        }

        $mime = strtolower((string) ($file->getMimeType() ?: ''));
        $ext = strtolower((string) ($file->getClientOriginalExtension() ?: $file->guessExtension() ?: ''));
        $allowedMime = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif'];
        $allowedExt = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if ((! in_array($mime, $allowedMime, true)) && (! in_array($ext, $allowedExt, true))) {
            throw ValidationException::withMessages([
                $fileField => 'Use a JPG, PNG, WEBP, or GIF image.',
            ]);
        }

        return $this->storeUploadedFile($file, $prefix);
    }

    private function storeImageDataUrl(mixed $dataUrl, string $prefix, string $errorField): ?string
    {
        $dataUrl = trim((string) $dataUrl);
        if ($dataUrl === '' || ! preg_match('#^data:image/(jpeg|jpg|png|gif|webp);base64,#i', $dataUrl, $m)) {
            return null;
        }

        $ext = strtolower($m[1]) === 'jpeg' ? 'jpg' : strtolower($m[1]);
        $binary = base64_decode(substr($dataUrl, strpos($dataUrl, ',') + 1), true);
        if ($binary === false || $binary === '') {
            throw ValidationException::withMessages([
                $errorField => 'The image data could not be read. Please choose the file again.',
            ]);
        }
        if (strlen($binary) > 10 * 1024 * 1024) {
            throw ValidationException::withMessages([
                $errorField => 'The image must be 10 MB or smaller.',
            ]);
        }

        return $this->writeSiteBinary($binary, $prefix, $ext, $errorField);
    }

    private function storeUploadedFile(UploadedFile $file, string $prefix): string
    {
        $ext = strtolower((string) ($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'jpg'));
        $ext = $ext === 'jpeg' ? 'jpg' : $ext;
        $allowed = $prefix === 'promo'
            ? ['jpg', 'png', 'gif', 'webp', 'mp4', 'webm', 'mov', 'm4v']
            : ['jpg', 'png', 'gif', 'webp'];
        if (! in_array($ext, $allowed, true)) {
            $ext = 'jpg';
        }

        $source = $file->getRealPath() ?: $file->getPathname();
        if (! is_string($source) || $source === '' || ! is_file($source)) {
            throw ValidationException::withMessages([
                $prefix === 'promo' ? 'promo_files' : 'hero_image' => 'The file could not be read. Please try again.',
            ]);
        }

        $name = $prefix.'-'.substr(uniqid('', true), -8).'.'.$ext;
        $videoMime = [
            'mp4' => 'video/mp4',
            'webm' => 'video/webm',
            'mov' => 'video/quicktime',
            'm4v' => 'video/mp4',
        ];
        $mime = $videoMime[$ext] ?? ($ext === 'jpg' ? 'image/jpeg' : 'image/'.$ext);

        try {
            return \App\Support\PersistedUpload::putFile('/images/site/'.$name, $source, $mime);
        } catch (\Throwable $e) {
            throw ValidationException::withMessages([
                $prefix === 'promo' ? 'promo_files' : 'hero_image' => 'The file could not be saved. Check that storage is writable.',
            ]);
        }
    }

    private function writeSiteBinary(string $binary, string $prefix, string $ext, string $errorField): string
    {
        $name = $prefix.'-'.substr(uniqid('', true), -8).'.'.$ext;
        $videoMime = [
            'mp4' => 'video/mp4',
            'webm' => 'video/webm',
            'mov' => 'video/quicktime',
            'm4v' => 'video/mp4',
        ];
        $mime = $videoMime[$ext] ?? ($ext === 'jpg' ? 'image/jpeg' : 'image/'.$ext);

        try {
            return \App\Support\PersistedUpload::put('/images/site/'.$name, $binary, $mime);
        } catch (\Throwable $e) {
            throw ValidationException::withMessages([
                $errorField => 'The file could not be saved. Check that storage is writable.',
            ]);
        }
    }

    private function syncPromoMedia(Request $request): array
    {
        $existing = SiteSettings::promoMedia();
        if ($request->boolean('remove_promo_image')) {
            foreach ($existing as $item) {
                $this->deleteStoredImage((string) ($item['path'] ?? ''));
            }

            return [];
        }

        $remove = array_map(
            fn ($path) => \App\Support\PersistedUpload::normalize((string) $path),
            (array) $request->input('remove_promo_media', [])
        );
        $kept = [];
        foreach ($existing as $item) {
            $path = \App\Support\PersistedUpload::normalize((string) ($item['path'] ?? ''));
            if ($path === '' || in_array($path, $remove, true)) {
                if ($path !== '') {
                    $this->deleteStoredImage($path);
                }
                continue;
            }
            $kept[] = $item;
        }

        $added = [];
        $fromData = $this->resolveSiteImage($request, 'promo_image', 'promo_image_data', 'promo');
        if ($fromData !== null) {
            $added[] = SiteSettings::promoMediaItem($fromData);
        }

        $files = $request->file('promo_files', []);
        if ($files instanceof UploadedFile) {
            $files = [$files];
        }
        foreach ((array) $files as $file) {
            if (! $file instanceof UploadedFile || ! $file->isValid()) {
                continue;
            }
            $stored = $this->storePromoFile($file);
            if ($stored !== null) {
                $added[] = $stored;
            }
        }

        $merged = array_values(array_filter(array_merge($kept, $added), fn ($item) => ($item['path'] ?? '') !== ''));
        $unique = [];
        $seen = [];
        foreach ($merged as $item) {
            $key = (string) $item['path'];
            if (isset($seen[$key])) {
                continue;
            }
            $seen[$key] = true;
            $unique[] = $item;
            if (count($unique) >= 12) {
                break;
            }
        }

        return $unique;
    }

    private function storePromoFile(UploadedFile $file): array
    {
        $mime = strtolower((string) ($file->getMimeType() ?: ''));
        $ext = strtolower((string) ($file->getClientOriginalExtension() ?: $file->guessExtension() ?: ''));
        $ext = $ext === 'jpeg' ? 'jpg' : $ext;
        $imageMime = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif'];
        $videoMime = ['video/mp4', 'video/webm', 'video/quicktime', 'video/ogg', 'video/x-m4v', 'video/x-mp4', 'application/mp4'];
        $imageExt = ['jpg', 'png', 'webp', 'gif'];
        $videoExt = ['mp4', 'webm', 'mov', 'm4v', 'ogg'];
        $isImage = in_array($mime, $imageMime, true) || in_array($ext, $imageExt, true);
        $isVideo = in_array($mime, $videoMime, true) || in_array($ext, $videoExt, true);
        if (! $isImage && ! $isVideo) {
            throw ValidationException::withMessages([
                'promo_files' => 'Use JPG, PNG, WEBP, GIF photos or MP4 / WEBM videos.',
            ]);
        }

        $path = $this->storeUploadedFile($file, 'promo');

        return SiteSettings::promoMediaItem($path, $isVideo ? 'video' : 'image');
    }

    private function firstPromoImagePath(array $media): string
    {
        foreach ($media as $item) {
            if (($item['type'] ?? '') !== 'video') {
                return (string) ($item['path'] ?? '');
            }
        }

        return (string) (($media[0]['path'] ?? ''));
    }

    private function promoFileRules(): array
    {
        return [
            'nullable',
            function (string $attribute, $value, $fail) {
                if ($value === null || $value === '') {
                    return;
                }
                if (! $value instanceof UploadedFile) {
                    $fail('Use a photo or a short MP4 / WEBM video.');
                    return;
                }
                if ($value->getError() === UPLOAD_ERR_NO_FILE) {
                    return;
                }
                if (! $value->isValid()) {
                    $fail($this->describeUploadError($value));
                    return;
                }
                if ($value->getSize() > self::PROMO_FILE_MAX_KB * 1024) {
                    $fail('Each promo photo or video must be 100 MB or smaller.');
                }
            },
        ];
    }

    private function describeUploadError(UploadedFile $file): string
    {
        return match ($file->getError()) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'That photo or video is too large to receive. Use a shorter MP4 or WEBM clip under 100 MB, then save again.',
            UPLOAD_ERR_PARTIAL => 'The file only uploaded partway. Please try again.',
            UPLOAD_ERR_NO_TMP_DIR => 'The server is missing a temporary folder for uploads. Try the file again.',
            UPLOAD_ERR_CANT_WRITE => 'The server could not save that photo or video.',
            UPLOAD_ERR_EXTENSION => 'A server extension blocked the upload.',
            default => 'That photo or video could not be uploaded. Try a shorter MP4 or WEBM clip under 100 MB.',
        };
    }

    private function deleteStoredImage(string $path): void
    {
        $path = trim($path);
        if ($path === '' || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return;
        }

        $normalized = '/'.ltrim(str_replace('\\', '/', $path), '/');

        \App\Support\PersistedUpload::forget($normalized);
    }
}
