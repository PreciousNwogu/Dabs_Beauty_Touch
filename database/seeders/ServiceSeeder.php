<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            ['name' => 'Small Knotless Braids', 'slug' => 'small-knotless', 'base_price' => 170.00],
            ['name' => 'Smedium Knotless Braids', 'slug' => 'smedium-knotless', 'base_price' => 150.00],
            ['name' => 'Wig Installation', 'slug' => 'wig-installation', 'base_price' => 150.00],
            ['name' => 'Medium Knotless Braids', 'slug' => 'medium-knotless', 'base_price' => 130.00],
            ['name' => 'Jumbo Knotless Braids', 'slug' => 'jumbo-knotless', 'base_price' => 100.00],
            ['name' => 'Kids Braids', 'slug' => 'kids-braids', 'base_price' => 80.00],
            ['name' => 'Stitch Braids', 'slug' => 'stitch-braids', 'base_price' => 120.00],
            ['name' => 'Hair Mask/Relaxing', 'slug' => 'hair-mask', 'base_price' => 50.00],
            ['name' => 'Smedium Boho Braids', 'slug' => 'boho-braids', 'base_price' => 150.00],
            // Popular Services
            ['name' => 'Weaving Crotchet', 'slug' => 'weaving-crotchet', 'base_price' => 80.00],
            ['name' => 'Single Crotchet', 'slug' => 'single-crotchet', 'base_price' => 150.00],
            ['name' => 'Natural Hair Twist', 'slug' => 'natural-hair-twist', 'base_price' => 50.00],
            ['name' => 'Weaving No-Extension', 'slug' => 'weaving-no-extension', 'base_price' => 30.00],
            ['name' => 'Kinky Twist', 'slug' => 'kinky-twist', 'base_price' => 120.00],
            ['name' => 'Twist Braids', 'slug' => 'twist-braids', 'base_price' => 130.00],
            // ['name' => 'Custom Service Request', 'slug' => 'custom', 'base_price' => 150.00],
        ];

        foreach ($services as $s) {
            Service::updateOrCreate(['slug' => $s['slug']], $s);
        }
    }
}
