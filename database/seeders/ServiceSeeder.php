<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            // Knotless Braids
            ['name' => 'Small Knotless Braids', 'slug' => 'small-knotless', 'base_price' => 170.00],
            ['name' => 'Smedium Knotless Braids', 'slug' => 'smedium-knotless', 'base_price' => 150.00],
            ['name' => 'Medium Knotless Braids', 'slug' => 'medium-knotless', 'base_price' => 130.00],
            ['name' => 'Jumbo Knotless Braids', 'slug' => 'jumbo-knotless', 'base_price' => 100.00],
            

            
            // Stitch Braids
            ['name' => 'Stitch Braids', 'slug' => 'stitch-braids', 'base_price' => 120.00],
            
            // Hair Treatment
            ['name' => 'Hair Mask/Relaxing', 'slug' => 'hair-mask', 'base_price' => 50.00],
            ['name' => 'Chemical Relaxer', 'slug' => 'chemical-relaxer', 'base_price' => 50.00],
            
            // Boho Braids
            ['name' => 'Small Boho Braids', 'slug' => 'small-boho', 'base_price' => 180.00],
            ['name' => 'Smedium Boho Braids', 'slug' => 'smedium-boho', 'base_price' => 150.00],
            ['name' => 'Medium Boho Braids', 'slug' => 'medium-boho', 'base_price' => 130.00],
            ['name' => 'Jumbo/Large Boho Braids', 'slug' => 'jumbo-boho', 'base_price' => 100.00],
            
            // Twist Styles
            ['name' => 'Small Twists', 'slug' => 'small-twist', 'base_price' => 150.00],
            ['name' => 'Medium Twists', 'slug' => 'medium-twist', 'base_price' => 120.00],
            ['name' => 'Jumbo/Large Twists', 'slug' => 'jumbo-twist', 'base_price' => 100.00],
            ['name' => 'Small Natural Hair Twist', 'slug' => 'small-natural-hair-twist', 'base_price' => 80.00],
            ['name' => 'Medium Natural Hair Twist', 'slug' => 'medium-natural-hair-twist', 'base_price' => 60.00],
            
            // Cornrow/Weave Styles
            ['name' => 'Stitch Weave', 'slug' => 'stitch-weave', 'base_price' => 100.00],
            ['name' => 'Cornrow Weave', 'slug' => 'cornrow-weave', 'base_price' => 100.00],
            ['name' => 'Under-wig Weave (no extension)', 'slug' => 'under-wig-weave', 'base_price' => 30.00],
            ['name' => 'Weave&Braid Mixed', 'slug' => 'weave-braid-mixed', 'base_price' => 150.00],
            
            // French Curl Braids
            ['name' => 'Small French Curl Braids', 'slug' => 'small-french-curl', 'base_price' => 200.00],
            ['name' => 'Smedium French Curl Braids', 'slug' => 'smedium-french-curl', 'base_price' => 170.00],
            ['name' => 'Medium French Curl Braids', 'slug' => 'medium-french-curl', 'base_price' => 150.00],
            ['name' => 'Large French Curl Braids', 'slug' => 'large-french-curl', 'base_price' => 120.00],
            
            // Crotchet Styles
            ['name' => '2/3 Line Single Crochet', 'slug' => 'line-single', 'base_price' => 100.00],
            ['name' => 'Afro Crotchet', 'slug' => 'afro-crotchet', 'base_price' => 120.00],
            ['name' => 'Individual Loc', 'slug' => 'individual-loc', 'base_price' => 150.00],
            ['name' => 'Butterfly Locks', 'slug' => 'butterfly-locks', 'base_price' => 150.00],
            ['name' => 'Weave Crotchet', 'slug' => 'weave-crotchet', 'base_price' => 80.00],
            
            // Popular Services (legacy entries)
            ['name' => 'Weaving Crotchet', 'slug' => 'weaving-crotchet', 'base_price' => 80.00],
            ['name' => 'Single Crotchet', 'slug' => 'single-crotchet', 'base_price' => 150.00],
            ['name' => 'Natural Hair Twist', 'slug' => 'natural-hair-twist', 'base_price' => 50.00],
            ['name' => 'Weaving No-Extension', 'slug' => 'weaving-no-extension', 'base_price' => 30.00],
            ['name' => 'Kinky Twist', 'slug' => 'kinky-twist', 'base_price' => 120.00],
            ['name' => 'Twist Braids', 'slug' => 'twist-braids', 'base_price' => 130.00],
        ];

        foreach ($services as $s) {
            Service::updateOrCreate(['slug' => $s['slug']], $s);
        }
    }
}
