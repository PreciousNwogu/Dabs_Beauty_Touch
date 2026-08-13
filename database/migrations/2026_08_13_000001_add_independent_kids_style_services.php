<?php

use App\Support\KidsStyleCatalog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('services')) {
            return;
        }

        $now = now();
        foreach (KidsStyleCatalog::definitions() as $def) {
            $slugs = array_values(array_unique(array_merge([$def['slug']], $def['alt_slugs'] ?? [])));
            $exists = DB::table('services')
                ->whereIn('slug', $slugs)
                ->orWhere('name', $def['name'])
                ->exists();
            if ($exists) {
                continue;
            }

            $row = [
                'name' => $def['name'],
                'slug' => $def['slug'],
                'base_price' => $def['default_price'],
                'description' => 'Kids Braids selector style. Edit this price independently of other services.',
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if (Schema::hasColumn('services', 'discount_price')) {
                $row['discount_price'] = null;
            }
            if (Schema::hasColumn('services', 'category')) {
                $row['category'] = 'Kids Braids';
            }
            if (Schema::hasColumn('services', 'is_active')) {
                $row['is_active'] = 1;
            }
            if (Schema::hasColumn('services', 'for_kids')) {
                $row['for_kids'] = 1;
            }

            DB::table('services')->insert($row);
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('services')) {
            return;
        }

        $createdSlugs = ['half_weave_braid', 'half_weave_crotchet', 'crotchet_style'];
        DB::table('services')->whereIn('slug', $createdSlugs)->delete();
    }
};
