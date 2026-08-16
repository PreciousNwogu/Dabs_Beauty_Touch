<?php

namespace App\Console\Commands;

use App\Support\PersistedUpload;
use Illuminate\Console\Command;

class PersistSiteImagesCommand extends Command
{
    protected $signature = 'images:persist';

    protected $description = 'Restore saved site photos to disk after deploy, then keep any local photos that are still present';

    public function handle(): int
    {
        $restored = PersistedUpload::restoreAll();
        $captured = PersistedUpload::captureReferenced();
        $this->info("Restored {$restored} saved photo(s). Kept {$captured} photo(s) from disk.");

        return self::SUCCESS;
    }
}
