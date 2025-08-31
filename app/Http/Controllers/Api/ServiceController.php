<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    // Public endpoint returning service prices (name => base_price)
    public function prices()
    {
        $services = Service::all(['name', 'slug', 'base_price']);
        return response()->json($services->mapWithKeys(function($s) {
            return [$s->slug => (float) $s->base_price];
        }));
    }
}
