<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdultServiceCatalog;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $hasCat = \Illuminate\Support\Facades\Schema::hasColumn('services', 'category');
        $q = Service::orderBy('name');
        if ($hasCat) {
            $q = Service::orderBy('category')->orderBy('name');
            $categories = Service::whereNotNull('category')->distinct()->pluck('category')->sort()->values();
        } else {
            $categories = collect();
        }
        $services = $q->get();
        $categories = AdultServiceCatalog::mergedNames($categories);
        return view('admin.services.index', compact('services', 'categories'));
    }

    public function create()
    {
        $categories = $this->adultCategories();
        $galleryImages = $this->galleryImages();
        return view('admin.services.form', ['service' => null, 'categories' => $categories, 'galleryImages' => $galleryImages]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255|unique:services,name',
            'slug'           => 'nullable|string|max:255',
            'base_price'     => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:base_price',
            'discount_ends_at' => 'nullable|date|after:now',
            'description'    => 'nullable|string',
            'image'          => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,avif|max:5120',
            'image_url'      => 'nullable|string|max:500',
            'remove_image'   => 'nullable|boolean',
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
            'size_enabled'   => 'nullable|array',
            'size_price'     => 'nullable|array',
        ]);

        $data = $this->normalizeServicePayload($data);
        $data['image_url'] = $this->resolveServiceImage($request);

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        $categories = $this->adultCategories();
        if (empty($service->category)) {
            $mapped = AdultServiceCatalog::hardcodedCategoryBySlug()[$service->slug] ?? null;
            if ($mapped) {
                $service->category = $mapped;
            }
        }
        $galleryImages = $this->galleryImages();
        return view('admin.services.form', compact('service', 'categories', 'galleryImages'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255|unique:services,name,' . $service->id,
            'slug'           => 'nullable|string|max:255',
            'base_price'     => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'discount_ends_at' => 'nullable|date',
            'description'    => 'nullable|string',
            'image'          => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,avif|max:5120',
            'image_url'      => 'nullable|string|max:500',
            'remove_image'   => 'nullable|boolean',
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
            'size_enabled'   => 'nullable|array',
            'size_price'     => 'nullable|array',
        ]);

        $data = $this->normalizeServicePayload($data, $service);
        $data['image_url'] = $this->resolveServiceImage($request, $service);

        $service->update($data);

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

        if (!empty($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        } elseif (!$service) {
            $data['slug'] = Service::makeSlug($data['name']);
        } else {
            unset($data['slug']);
        }

        $data['is_active'] = !empty($data['is_active']);
        $data['for_kids'] = !empty($data['for_kids']);
        $data['has_length'] = $data['for_kids'] ? true : !empty($data['has_length']);
        $data['has_tip_finish'] = $data['for_kids'] ? false : !empty($data['has_tip_finish']);
        $data['has_row_options'] = $data['for_kids'] ? false : !empty($data['has_row_options']);
        $data['has_eight_to_ten_rows'] = $data['for_kids'] ? false : !empty($data['has_eight_to_ten_rows']);
        $data['has_fifteen_plus_rows'] = $data['for_kids'] ? false : !empty($data['has_fifteen_plus_rows']);
        $data['eight_to_ten_rows_price'] = $data['for_kids'] ? 0 : self::normalizeRowPrice($data['eight_to_ten_rows_price'] ?? null, 0);
        $data['ten_plus_rows_price'] = $data['for_kids'] ? 30 : self::normalizeRowPrice($data['ten_plus_rows_price'] ?? null, 30);
        $data['fifteen_plus_rows_price'] = $data['for_kids'] ? 30 : self::normalizeRowPrice($data['fifteen_plus_rows_price'] ?? null, 30);
        $data['duration'] = $data['for_kids'] ? null : (isset($data['duration']) && $data['duration'] !== '' ? $data['duration'] : null);
        $data['discount_price'] = (isset($data['discount_price']) && $data['discount_price'] !== '') ? $data['discount_price'] : null;
        if (empty($data['discount_price'])) {
            $data['discount_ends_at'] = null;
        }

        $sizeOptions = [];
        if (empty($data['for_kids'])) {
            $enabled = $data['size_enabled'] ?? [];
            $prices = $data['size_price'] ?? [];
            foreach (array_keys(AdultServiceCatalog::sizeLabels()) as $sizeKey) {
                if (empty($enabled[$sizeKey])) {
                    continue;
                }
                $price = isset($prices[$sizeKey]) && $prices[$sizeKey] !== '' ? (float) $prices[$sizeKey] : null;
                if ($price === null || $price < 0) {
                    $price = isset($data['base_price']) ? (float) $data['base_price'] : 0;
                }
                $sizeOptions[$sizeKey] = $price;
            }
        }
        $data['size_options'] = $sizeOptions ?: null;
        unset($data['size_enabled'], $data['size_price'], $data['image'], $data['remove_image']);

        foreach (['has_length', 'has_tip_finish', 'has_row_options', 'has_eight_to_ten_rows', 'has_fifteen_plus_rows', 'eight_to_ten_rows_price', 'ten_plus_rows_price', 'fifteen_plus_rows_price', 'duration', 'size_options'] as $col) {
            if (!Schema::hasColumn('services', $col)) {
                unset($data[$col]);
            }
        }

        return $data;
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
                    'url' => asset('images/' . $name),
                    'name' => $name,
                    'source' => 'gallery',
                ];
            }
        }

        $uploadDir = storage_path('app/public/service-images');
        if (is_dir($uploadDir)) {
            foreach (File::files($uploadDir) as $file) {
                if (!in_array(strtolower($file->getExtension()), $ext, true)) {
                    continue;
                }
                $name = $file->getFilename();
                $out[] = [
                    'path' => '/storage/service-images/' . $name,
                    'url' => asset('storage/service-images/' . $name),
                    'name' => $name,
                    'source' => 'upload',
                ];
            }
        }

        usort($out, fn ($a, $b) => strcasecmp($a['name'], $b['name']));

        return $out;
    }

    private function resolveServiceImage(Request $request, ?Service $existing = null): ?string
    {
        if ($request->hasFile('image')) {
            $this->deleteStoredServiceImage($existing?->image_url);
            $stored = $request->file('image')->store('service-images', 'public');
            return '/storage/' . ltrim(str_replace('\\', '/', $stored), '/');
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

        return $picked;
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
        if (!$url || !str_contains($url, '/storage/service-images/')) {
            return;
        }

        $path = parse_url($url, PHP_URL_PATH) ?: $url;
        $relative = ltrim(str_replace('/storage/', '', $path), '/');
        if ($relative !== '' && Storage::disk('public')->exists($relative)) {
            Storage::disk('public')->delete($relative);
        }
    }
}
