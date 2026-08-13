<?php

use App\Support\AdultServiceCatalog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('services')) {
            return;
        }

        if (!Schema::hasColumn('services', 'has_fifteen_plus_rows')) {
            Schema::table('services', function (Blueprint $table) {
                $after = Schema::hasColumn('services', 'has_row_options') ? 'has_row_options' : 'has_tip_finish';
                $table->boolean('has_fifteen_plus_rows')->default(false)->after($after);
            });
        }

        if (Schema::hasColumn('services', 'has_row_options') && Schema::hasColumn('services', 'has_fifteen_plus_rows')) {
            DB::table('services')
                ->where('has_row_options', true)
                ->update(['has_fifteen_plus_rows' => true]);
        }

        $noLengthSlugs = [
            'under-wig-weave',
            'small-natural-hair-twist',
            'medium-natural-hair-twist',
            'line-single',
            'afro-crotchet',
            'individual-crotchet',
            'individual-loc',
            'butterfly-locks',
            'weave-crotchet',
            'natural-hair-treatment',
            'chemical-relaxer',
            'hair-mask',
        ];
        if (Schema::hasColumn('services', 'has_length')) {
            DB::table('services')->whereIn('slug', $noLengthSlugs)->update(['has_length' => false]);
        }

        $bothRowSlugs = ['stitch-weave', 'cornrow-weave'];
        $rowUpdate = [];
        if (Schema::hasColumn('services', 'has_row_options')) {
            $rowUpdate['has_row_options'] = true;
        }
        if (Schema::hasColumn('services', 'has_fifteen_plus_rows')) {
            $rowUpdate['has_fifteen_plus_rows'] = true;
        }
        if ($rowUpdate) {
            DB::table('services')->whereIn('slug', $bothRowSlugs)->update($rowUpdate);
        }

        if (Schema::hasColumn('services', 'category')) {
            foreach (AdultServiceCatalog::hardcodedCategoryBySlug() as $slug => $category) {
                DB::table('services')
                    ->where('slug', $slug)
                    ->where(function ($q) {
                        $q->whereNull('category')->orWhere('category', '');
                    })
                    ->update(['category' => $category]);
            }
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('services') || !Schema::hasColumn('services', 'has_fifteen_plus_rows')) {
            return;
        }

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('has_fifteen_plus_rows');
        });
    }
};
