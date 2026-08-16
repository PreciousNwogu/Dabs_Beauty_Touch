<?php

use App\Support\KidsStyleCatalog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('services')) {
            return;
        }

        foreach (KidsStyleCatalog::definitions() as $def) {
            $slugs = array_values(array_unique(array_merge([$def['slug']], $def['alt_slugs'] ?? [])));
            $row = DB::table('services')->whereIn('slug', $slugs)->first();
            if (! $row) {
                continue;
            }

            $updates = [];
            $description = trim((string) ($row->description ?? ''));
            if ($description === '' || KidsStyleCatalog::isPlaceholderDescription($description)) {
                $updates['description'] = trim((string) ($def['blurb'] ?? ''));
            }
            if (Schema::hasColumn('services', 'duration') && trim((string) ($row->duration ?? '')) === '') {
                $updates['duration'] = $def['duration'] ?? null;
            }
            if (Schema::hasColumn('services', 'has_length')) {
                $updates['has_length'] = empty($def['disable_steps']);
            }
            if (Schema::hasColumn('services', 'for_kids') && empty($row->for_kids)) {
                $updates['for_kids'] = 1;
            }
            if (Schema::hasColumn('services', 'category') && trim((string) ($row->category ?? '')) === '') {
                $updates['category'] = 'Kids Braids';
            }
            if ($updates === []) {
                continue;
            }

            $updates['updated_at'] = now();
            DB::table('services')->where('id', $row->id)->update($updates);
        }
    }

    public function down(): void
    {
        // One-way backfill of kids CMS copy and booking flags.
    }
};
