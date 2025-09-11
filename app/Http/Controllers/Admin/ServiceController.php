<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);
        $service->update($data);
        return redirect()->route('admin.services.index')->with('success', 'Service updated');
    }
}
