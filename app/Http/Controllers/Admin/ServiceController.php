<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('category')->orderBy('name')->get();
        $categories = Service::whereNotNull('category')->distinct()->pluck('category')->sort()->values();
        return view('admin.services.index', compact('services', 'categories'));
    }

    public function create()
    {
        $categories = Service::whereNotNull('category')->distinct()->pluck('category')->sort()->values();
        return view('admin.services.form', ['service' => null, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255|unique:services,name',
            'slug'           => 'nullable|string|max:255',
            'base_price'     => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:base_price',
            'description'    => 'nullable|string',
            'image_url'      => 'nullable|string|max:500',
            'category'       => 'nullable|string|max:100',
            'new_category'   => 'nullable|string|max:100',
            'is_active'      => 'nullable|boolean',
        ]);

        // Prefer hand-typed new category
        if (!empty($data['new_category'])) {
            $data['category'] = trim($data['new_category']);
        }
        unset($data['new_category']);

        $data['slug'] = !empty($data['slug'])
            ? Str::slug($data['slug'])
            : Service::makeSlug($data['name']);

        $data['is_active'] = !empty($data['is_active']);
        $data['discount_price'] = $data['discount_price'] !== '' ? $data['discount_price'] : null;

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        $categories = Service::whereNotNull('category')->distinct()->pluck('category')->sort()->values();
        return view('admin.services.form', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255|unique:services,name,' . $service->id,
            'slug'           => 'nullable|string|max:255',
            'base_price'     => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'description'    => 'nullable|string',
            'image_url'      => 'nullable|string|max:500',
            'category'       => 'nullable|string|max:100',
            'new_category'   => 'nullable|string|max:100',
            'is_active'      => 'nullable|boolean',
        ]);

        if (!empty($data['new_category'])) {
            $data['category'] = trim($data['new_category']);
        }
        unset($data['new_category']);

        if (!empty($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        }

        $data['is_active'] = !empty($data['is_active']);
        $data['discount_price'] = (isset($data['discount_price']) && $data['discount_price'] !== '') ? $data['discount_price'] : null;

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function updateDiscount(Request $request, Service $service)
    {
        $data = $request->validate([
            'discount_price' => 'nullable|numeric|min:0',
        ]);
        $service->update([
            'discount_price' => ($data['discount_price'] !== null && $data['discount_price'] !== '') ? $data['discount_price'] : null,
        ]);
        return redirect()->route('admin.services.index')->with('success', 'Discount updated.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service deleted.');
    }
}
