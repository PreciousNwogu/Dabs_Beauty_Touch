<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdultServiceCatalog;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class ServiceController extends Controller
{
    public function index()
    {
        AdultServiceCatalog::ensureRequiredCmsServices();
        \App\Support\KidsStyleCatalog::ensureCmsServices();
        $hasCat = \Illuminate\Support\Facades\Schema::hasColumn('services', 'category');
        $q = Service::orderBy('name');
        if ($hasCat) {
            $q = Service::orderBy('category')->orderBy('name');
            $categories = Service::whereNotNull('category')->distinct()->pluck('category')->sort()->values();
        } else {
            $categories = collect();
        }
        $services = $q->get();
        $categories = AdultServiceCatalog::adminFilterNames($categories);
        return view('admin.services.index', compact('services', 'categories'));
    }

    public function create(Request $request)
    {
        \App\Support\KidsStyleCatalog::ensureCmsServices();
        $categories = $this->adultCategories();
        $galleryImages = $this->galleryImages();
        $prefillKids = $request->boolean('for_kids');
        return view('admin.services.form', [
            'service' => null,
            'categories' => $categories,
            'galleryImages' => $galleryImages,
            'prefillKids' => $prefillKids,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255|unique:services,name',
            'slug'           => 'nullable|string|max:255|unique:services,slug',
            'base_price'     => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:base_price',
            'discount_ends_at' => 'nullable|date|after:now',
            'description'    => 'nullable|string|max:1000',
            'image'          => $this->imageUploadRules(),
            'image_data'     => 'nullable|string',
            'image_url'      => 'nullable|string|max:500',
            'remove_image'   => 'nullable|boolean',
            'use_as_category_card' => 'nullable|boolean',
            'category'       => 'nullable|string|max:100',
            'new_category'   => 'nullable|string|max:100',
            'is_active'      => 'nullable|boolean',
            'for_kids'       => 'nullable|boolean',
            'has_length'     => 'nullable|boolean',
            'has_tip_finish' => 'nullable|boolean',
            'has_row_options'=> 'nullable|boolean',
            'has_eight_to_ten_rows'=> 'nullable|boolean',
            'has_fifteen_plus_rows'=> 'nullable|boolean',
            'eight_to_ten_rows_price' => 'nullable|numeric|min:0',
            'ten_plus_rows_price' => 'nullable|numeric|min:0',
            'fifteen_plus_rows_price' => 'nullable|numeric|min:0',
            'duration'       => 'nullable|string|max:50',
            'offer_braid_sizes' => 'nullable|boolean',
            'size_enabled'   => 'nullable|array',
            'size_price'     => 'nullable|array',
            'size_price.*'   => 'nullable|numeric|min:0',
        ], $this->imageUploadMessages());

        $data = $this->normalizeServicePayload($data);
        $this->assertUniqueServiceSlug($data['slug'] ?? null);
        $data['image_url'] = $this->resolveServiceImage($request);
        $this->clearSiblingCategoryCards($data);

        try {
            Service::create($data);
        } catch (QueryException $e) {
            $this->rethrowUniqueServiceConflict($e);
        }

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function show(Service $service)
    {
        return redirect()->route('admin.services.edit', $service);
    }

    public function edit(Service $service)
    {
        \App\Support\KidsStyleCatalog::ensureCmsServices();
        $categories = $this->adultCategories();
        if (empty($service->category)) {
            $mapped = AdultServiceCatalog::hardcodedCategoryBySlug()[$service->slug] ?? null;
            if ($mapped) {
                $service->category = $mapped;
            }
        }
        $galleryImages = $this->galleryImages();
        $prefillKids = false;
        return view('admin.services.form', compact('service', 'categories', 'galleryImages', 'prefillKids'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255|unique:services,name,' . $service->id,
            'slug'           => 'nullable|string|max:255|unique:services,slug,' . $service->id,
            'base_price'     => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'discount_ends_at' => 'nullable|date',
            'description'    => 'nullable|string|max:1000',
            'image'          => $this->imageUploadRules(),
            'image_data'     => 'nullable|string',
            'image_url'      => 'nullable|string|max:500',
            'remove_image'   => 'nullable|boolean',
            'use_as_category_card' => 'nullable|boolean',
            'category'       => 'nullable|string|max:100',
            'new_category'   => 'nullable|string|max:100',
            'is_active'      => 'nullable|boolean',
            'for_kids'       => 'nullable|boolean',
            'has_length'     => 'nullable|boolean',
            'has_tip_finish' => 'nullable|boolean',
            'has_row_options'=> 'nullable|boolean',
            'has_eight_to_ten_rows'=> 'nullable|boolean',
            'has_fifteen_plus_rows'=> 'nullable|boolean',
            'eight_to_ten_rows_price' => 'nullable|numeric|min:0',
            'ten_plus_rows_price' => 'nullable|numeric|min:0',
            'fifteen_plus_rows_price' => 'nullable|numeric|min:0',
            'duration'       => 'nullable|string|max:50',
            'offer_braid_sizes' => 'nullable|boolean',
            'size_enabled'   => 'nullable|array',
            'size_price'     => 'nullable|array',
            'size_price.*'   => 'nullable|numeric|min:0',
        ], $this->imageUploadMessages());

        $data = $this->normalizeServicePayload($data, $service);
        $this->assertUniqueServiceSlug($data['slug'] ?? $service->slug, $service->id);
        $data['image_url'] = $this->resolveServiceImage($request, $service);
        $this->clearSiblingCategoryCards($data, $service);

        try {
            $service->update($data);
        } catch (QueryException $e) {
            $this->rethrowUniqueServiceConflict($e);
        }

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function updateDiscount(Request $request, Service $service)
    {
        $data = $request->validate([
            'discount_price'  => 'nullable|numeric|min:0',
            'discount_ends_at' => 'nullable|date',
        ]);
        $discountPrice = ($data['discount_price'] !== null && $data['discount_price'] !== '') ? $data['discount_price'] : null;
        $endsAt = !empty($data['discount_ends_at']) ? $data['discount_ends_at'] : null;
        $service->update([
            'discount_price'   => $discountPrice,
            'discount_ends_at' => $discountPrice === null ? null : $endsAt,
        ]);
        return redirect()->route('admin.services.index')->with('success', 'Discount updated.');
    }

    public function destroy(Service $service)
    {
        if (AdultServiceCatalog::isHardcodedSlug($service->slug, $service->name)
            || \App\Support\KidsStyleCatalog::isCatalogSlug($service->slug)) {
            $service->update(['is_active' => false]);
            $where = \App\Support\KidsStyleCatalog::isCatalogSlug($service->slug) ? 'kids selector' : 'website';
            return redirect()->route('admin.services.index')->with('success', "This style is now hidden from the {$where}. Edit it and set Active to show it again.");
        }
        \App\Support\PersistedUpload::forget($service->image_url);
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service deleted.');
    }

    private function adultCategories()
    {
        $db = Schema::hasColumn('services', 'category')
            ? Service::whereNotNull('category')->distinct()->pluck('category')
            : collect();

        return AdultServiceCatalog::mergedNames($db);
    }

    private function normalizeServicePayload(array $data, ?Service $service = null): array
    {
        if (!empty($data['new_category'])) {
            $data['category'] = trim($data['new_category']);
        }
        unset($data['new_category']);

        $data['is_active'] = !empty($data['is_active']);
        $data['for_kids'] = !empty($data['for_kids']);

        if (!empty($data['slug']) || $service) {
            $incoming = (string) ($data['slug'] ?? $service->slug ?? '');
            $canonicalKids = $data['for_kids']
                ? (\App\Support\KidsStyleCatalog::canonicalSlug($incoming)
                    ?: ($service ? \App\Support\KidsStyleCatalog::canonicalSlug($service->slug) : null))
                : null;
            if ($canonicalKids) {
                $data['slug'] = $canonicalKids;
            } elseif (!empty($data['slug'])) {
                $data['slug'] = Str::slug($data['slug']);
            } elseif (!$service) {
                $data['slug'] = Service::makeSlug($data['name']);
            } else {
                unset($data['slug']);
            }
        } elseif (!$service) {
            $data['slug'] = Service::makeSlug($data['name']);
        } else {
            unset($data['slug']);
        }
        $data['use_as_category_card'] = $data['for_kids'] ? false : !empty($data['use_as_category_card']);
        $data['has_length'] = !empty($data['has_length']);
        $data['has_tip_finish'] = !empty($data['has_tip_finish']);
        $data['has_row_options'] = !empty($data['has_row_options']);
        $data['has_eight_to_ten_rows'] = !empty($data['has_eight_to_ten_rows']);
        $data['has_fifteen_plus_rows'] = !empty($data['has_fifteen_plus_rows']);
        $data['eight_to_ten_rows_price'] = self::normalizeRowPrice($data['eight_to_ten_rows_price'] ?? null, 0);
        $data['ten_plus_rows_price'] = self::normalizeRowPrice($data['ten_plus_rows_price'] ?? null, 30);
        $data['fifteen_plus_rows_price'] = self::normalizeRowPrice($data['fifteen_plus_rows_price'] ?? null, 30);
        $data['duration'] = (isset($data['duration']) && $data['duration'] !== '') ? $data['duration'] : null;
        if ($data['for_kids']) {
            $data['category'] = 'Kids Braids';
        }
        $data['discount_price'] = (isset($data['discount_price']) && $data['discount_price'] !== '') ? $data['discount_price'] : null;
        if (empty($data['discount_price'])) {
            $data['discount_ends_at'] = null;
        }

        $sizeOptions = [];
        $offerSizes = !empty($data['offer_braid_sizes']);
        if ($offerSizes) {
            $enabled = $data['size_enabled'] ?? [];
            $prices = $data['size_price'] ?? [];
            $base = isset($data['base_price']) ? (float) $data['base_price'] : 0;
            foreach (array_keys(AdultServiceCatalog::sizeLabels()) as $sizeKey) {
                if (empty($enabled[$sizeKey])) {
                    continue;
                }
                $price = isset($prices[$sizeKey]) && $prices[$sizeKey] !== '' ? (float) $prices[$sizeKey] : null;
                if ($price === null || $price < 0) {
                    $price = AdultServiceCatalog::suggestedSizePrice($base, $sizeKey);
                }
                $sizeOptions[$sizeKey] = $price;
            }
        }
        $data['size_options'] = $sizeOptions ?: null;
        unset($data['offer_braid_sizes'], $data['size_enabled'], $data['size_price'], $data['image'], $data['image_data'], $data['remove_image']);

        foreach (['has_length', 'has_tip_finish', 'has_row_options', 'has_eight_to_ten_rows', 'has_fifteen_plus_rows', 'eight_to_ten_rows_price', 'ten_plus_rows_price', 'fifteen_plus_rows_price', 'duration', 'size_options', 'use_as_category_card'] as $col) {
            if (!Schema::hasColumn('services', $col)) {
                unset($data[$col]);
            }
        }

        return $data;
    }

    private function clearSiblingCategoryCards(array $data, ?Service $service = null): void
    {
        if (empty($data['use_as_category_card']) || !Schema::hasColumn('services', 'use_as_category_card')) {
            return;
        }

        $category = $data['category'] ?? $service?->category;
        $query = Service::query()->when($service, fn ($q) => $q->where('id', '!=', $service->id));
        if (!empty($category)) {
            $query->where('category', $category)->update(['use_as_category_card' => false]);
            return;
        }

        if (($data['slug'] ?? $service?->slug) === 'kids-braids') {
            Service::where('slug', 'kids-braids')
                ->when($service, fn ($q) => $q->where('id', '!=', $service->id))
                ->update(['use_as_category_card' => false]);
        }
    }

    private static function normalizeRowPrice($value, float $default): float
    {
        if ($value === null || $value === '') {
            return $default;
        }
        $price = (float) $value;
        return $price < 0 ? $default : $price;
    }

    private function galleryImages(): array
    {
        $out = [];
        $ext = ['jpg', 'jpeg', 'png', 'webp', 'avif', 'gif'];

        $publicDir = public_path('images');
        if (is_dir($publicDir)) {
            foreach (File::files($publicDir) as $file) {
                if (!in_array(strtolower($file->getExtension()), $ext, true)) {
                    continue;
                }
                $name = $file->getFilename();
                $out[] = [
                    'path' => '/images/' . $name,
                    'url' => AdultServiceCatalog::publicImageUrl('/images/' . $name),
                    'name' => $name,
                    'source' => 'gallery',
                ];
            }
        }

        foreach ([
            storage_path('app/public/service-images') => '/storage/service-images/',
            public_path('images/services') => '/images/services/',
            public_path('images/uploads') => '/images/uploads/',
            public_path('images/site') => '/images/site/',
        ] as $uploadDir => $urlPrefix) {
            if (!is_dir($uploadDir)) {
                continue;
            }
            foreach (File::files($uploadDir) as $file) {
                if (!in_array(strtolower($file->getExtension()), $ext, true)) {
                    continue;
                }
                $name = $file->getFilename();
                $out[] = [
                    'path' => $urlPrefix . $name,
                    'url' => AdultServiceCatalog::publicImageUrl($urlPrefix . $name),
                    'name' => $name,
                    'source' => 'upload',
                ];
            }
        }

        usort($out, fn ($a, $b) => strcasecmp($a['name'], $b['name']));

        return $out;
    }

    private function imageUploadRules(): array
    {
        return [
            'nullable',
            function (string $attribute, $value, $fail) {
                if ($value === null || $value === '') {
                    return;
                }
                if (!$value instanceof UploadedFile) {
                    return;
                }
                if ($value->getError() === UPLOAD_ERR_NO_FILE) {
                    return;
                }
                if (!$value->isValid()) {
                    if (request()->filled('image_data')) {
                        return;
                    }
                    $fail($this->describeUploadError($value));
                    return;
                }
                $ext = strtolower((string) $value->getClientOriginalExtension());
                $mime = strtolower((string) ($value->getMimeType() ?: ''));
                $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];
                $allowedMime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/avif', 'image/jpg'];
                if ($ext !== '' && !in_array($ext, $allowedExt, true) && !in_array($mime, $allowedMime, true)) {
                    $fail('Use a JPG, PNG, WEBP, AVIF, or GIF image.');
                    return;
                }
                if ($value->getSize() > 10 * 1024 * 1024) {
                    $fail('The image must be 10 MB or smaller.');
                }
            },
        ];
    }

    private function imageUploadMessages(): array
    {
        return [
            'image.uploaded' => 'The image could not be received. Try a JPG or PNG under 10 MB.',
            'image.image' => 'That file is not a supported image. Use JPG, PNG, WEBP, AVIF, or GIF.',
            'image.mimes' => 'Use a JPG, PNG, WEBP, AVIF, or GIF image.',
            'image.max' => 'The image must be 10 MB or smaller.',
        ];
    }

    private function describeUploadError(UploadedFile $file): string
    {
        return match ($file->getError()) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'The image is too large. Use a file under 10 MB.',
            UPLOAD_ERR_PARTIAL => 'The image only uploaded partway. Please try again.',
            UPLOAD_ERR_NO_TMP_DIR => 'The server is missing a temporary folder for uploads.',
            UPLOAD_ERR_CANT_WRITE => 'The server could not save the uploaded image.',
            UPLOAD_ERR_EXTENSION => 'A server extension blocked the image upload.',
            default => 'The image could not be uploaded. Try a JPG or PNG under 10 MB.',
        };
    }

    private function resolveServiceImage(Request $request, ?Service $existing = null): ?string
    {
        $fromData = $this->storeImageDataUrl($request->input('image_data'));
        if ($fromData) {
            $this->deleteStoredServiceImage($existing?->image_url);
            return $fromData;
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if (!$file instanceof UploadedFile || !$file->isValid()) {
                throw ValidationException::withMessages([
                    'image' => $file instanceof UploadedFile
                        ? $this->describeUploadError($file)
                        : 'The image could not be uploaded.',
                ]);
            }

            $this->deleteStoredServiceImage($existing?->image_url);

            $ext = strtolower((string) ($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'jpg'));
            $binary = @file_get_contents($file->getRealPath() ?: $file->getPathname());
            if ($binary === false || $binary === '') {
                throw ValidationException::withMessages([
                    'image' => 'The image could not be read. Please try again.',
                ]);
            }

            return \App\Support\PersistedUpload::storeUpload('service', $binary, $ext, $file->getMimeType());
        }

        if ($request->boolean('remove_image')) {
            $this->deleteStoredServiceImage($existing?->image_url);
            return null;
        }

        $picked = trim((string) $request->input('image_url', ''));
        if ($picked === '') {
            return $existing?->image_url;
        }

        if (!$this->isAllowedImagePath($picked)) {
            return $existing?->image_url;
        }

        if ($existing && $existing->image_url && $existing->image_url !== $picked) {
            $this->deleteStoredServiceImage($existing->image_url);
        }

        try {
            $kept = \App\Support\PersistedUpload::persistExisting($picked);
        } catch (\Throwable $e) {
            Log::warning('Could not persist a service card photo.', [
                'path' => $picked,
                'error' => $e->getMessage(),
            ]);
            $kept = null;
        }

        return $kept ?: $picked;
    }

    private function assertUniqueServiceSlug(?string $slug, ?int $ignoreId = null): void
    {
        $slug = trim((string) $slug);
        if ($slug === '') {
            return;
        }

        $q = Service::query()->where('slug', $slug);
        if ($ignoreId) {
            $q->where('id', '!=', $ignoreId);
        }
        if ($q->exists()) {
            throw ValidationException::withMessages([
                'slug' => 'Another style already uses that web name. Leave the slug as it is and save the photo again.',
            ]);
        }
    }

    private function rethrowUniqueServiceConflict(QueryException $e): never
    {
        $sqlState = (string) ($e->errorInfo[0] ?? '');
        $message = strtolower($e->getMessage());
        if ($sqlState === '23000' || str_contains($message, 'unique') || str_contains($message, 'duplicate')) {
            throw ValidationException::withMessages([
                'name' => 'That style name or photo could not be saved because it collides with another service. Try again without renaming it.',
            ]);
        }

        throw $e;
    }

    private function storeImageDataUrl(?string $dataUrl): ?string
    {
        $dataUrl = trim((string) $dataUrl);
        if ($dataUrl === '' || !preg_match('#^data:image/(jpeg|jpg|png|gif|webp|avif);base64,#i', $dataUrl, $m)) {
            return null;
        }

        $ext = strtolower($m[1]) === 'jpeg' ? 'jpg' : strtolower($m[1]);
        $binary = base64_decode(substr($dataUrl, strpos($dataUrl, ',') + 1), true);
        if ($binary === false || $binary === '') {
            throw ValidationException::withMessages([
                'image' => 'The image data could not be read. Please choose the file again.',
            ]);
        }
        if (strlen($binary) > 10 * 1024 * 1024) {
            throw ValidationException::withMessages([
                'image' => 'The image must be 10 MB or smaller.',
            ]);
        }

        return \App\Support\PersistedUpload::storeUpload('service', $binary, $ext);
    }

    private function isAllowedImagePath(string $path): bool
    {
        if (preg_match('#^https?://#i', $path)) {
            return true;
        }

        return (bool) preg_match('#^/(images|storage/service-images)/#', $path);
    }

    private function deleteStoredServiceImage(?string $url): void
    {
        \App\Support\PersistedUpload::forget($url);
    }
}
