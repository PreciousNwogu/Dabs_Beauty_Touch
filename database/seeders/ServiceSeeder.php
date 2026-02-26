<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $now = now()->toDateTimeString();
        $rows = [
            ['name'=>'Small Knotless Braids','slug'=>'small-knotless','base_price'=>170,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Smedium Knotless Braids','slug'=>'smedium-knotless','base_price'=>150,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Wig Installation','slug'=>'wig-installation','base_price'=>150,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>0,'for_kids'=>0],
            ['name'=>'Medium Knotless Braids','slug'=>'medium-knotless','base_price'=>130,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Jumbo Knotless Braids','slug'=>'jumbo-knotless','base_price'=>100,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Kids Braids','slug'=>'kids-braids','base_price'=>80,'discount_price'=>50,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Stitch Braids','slug'=>'stitch-braids','base_price'=>120,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Hair Mask/Relaxing','slug'=>'hair-mask','base_price'=>50,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Medium Boho Braids','slug'=>'medium-boho','base_price'=>130,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Custom Service Request','slug'=>'custom','base_price'=>0,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Chemical Relaxer','slug'=>'chemical-relaxer','base_price'=>50,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Small Boho Braids','slug'=>'small-boho','base_price'=>180,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Smedium Boho Braids','slug'=>'smedium-boho','base_price'=>150,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Jumbo/Large Boho Braids','slug'=>'jumbo-boho','base_price'=>100,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Small Twists','slug'=>'small-twist','base_price'=>150,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Medium Twists','slug'=>'medium-twist','base_price'=>120,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Jumbo/Large Twists','slug'=>'jumbo-twist','base_price'=>100,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Small Natural Hair Twist','slug'=>'small-natural-hair-twist','base_price'=>80,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Medium Natural Hair Twist','slug'=>'medium-natural-hair-twist','base_price'=>60,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Stitch Weave','slug'=>'stitch-weave','base_price'=>100,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Cornrow Weave','slug'=>'cornrow-weave','base_price'=>100,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Under-wig Weave','slug'=>'under-wig-weave','base_price'=>30,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Weave&Braid Mixed','slug'=>'weave-braid-mixed','base_price'=>144,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Small French Curl Braids','slug'=>'small-french-curl','base_price'=>200,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Smedium French Curl Braids','slug'=>'smedium-french-curl','base_price'=>170,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Medium French Curl Braids','slug'=>'medium-french-curl','base_price'=>150,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Large French Curl Braids','slug'=>'large-french-curl','base_price'=>120,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'2/3 Line Single','slug'=>'line-single','base_price'=>100,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Afro Crotchet','slug'=>'afro-crotchet','base_price'=>120,'discount_price'=>100,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Individual Loc','slug'=>'individual-loc','base_price'=>150,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Butterfly Locks','slug'=>'butterfly-locks','base_price'=>140,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Weave Crotchet','slug'=>'weave-crotchet','base_price'=>80,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Weaving Crotchet','slug'=>'weaving-crotchet','base_price'=>80,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Single Crotchet','slug'=>'single-crotchet','base_price'=>150,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Natural Hair Twist','slug'=>'natural-hair-twist','base_price'=>50,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Weaving No-Extension','slug'=>'weaving-no-extension','base_price'=>30,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Kinky Twist','slug'=>'kinky-twist','base_price'=>120,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
            ['name'=>'Twist Braids','slug'=>'twist-braids','base_price'=>130,'discount_price'=>null,'description'=>null,'category'=>null,'is_active'=>1,'for_kids'=>0],
        ];

        foreach ($rows as &$row) {
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
        }

        // upsert on slug — safe to run on every deploy, won't duplicate
        DB::table('services')->upsert(
            $rows,
            ['slug'],
            ['name', 'base_price', 'discount_price', 'description', 'category', 'is_active', 'for_kids', 'updated_at']
        );
    }
}
