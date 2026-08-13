<?php

use App\Support\AdultServiceCatalog;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        AdultServiceCatalog::ensureRequiredCmsServices();
    }

    public function down(): void
    {
        // Keep the CMS rows; they may have been edited.
    }
};
