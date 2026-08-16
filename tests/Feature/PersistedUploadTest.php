<?php

namespace Tests\Feature;

use App\Models\StoredImage;
use App\Support\AdultServiceCatalog;
use App\Support\PersistedUpload;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class PersistedUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        foreach ([
            public_path('images/uploads'),
            public_path('images/site'),
        ] as $dir) {
            if (is_dir($dir)) {
                foreach (File::files($dir) as $file) {
                    if ($file->getFilename() === '.gitkeep') {
                        continue;
                    }
                    @unlink($file->getPathname());
                }
            }
        }

        parent::tearDown();
    }

    public function test_uploaded_photo_comes_back_after_the_file_is_deleted(): void
    {
        $png = hex2bin('89504e470d0a1a0a0000000d49484452000000010000000108060000001f15c4890000000a49444154789c63000100000500010d0a2db40000000049454e44ae426082');
        $path = PersistedUpload::storeUpload('service', $png, 'png', 'image/png');

        $this->assertStringStartsWith('/images/uploads/', $path);
        $this->assertFileExists(PersistedUpload::absolutePath($path));
        $this->assertTrue(StoredImage::query()->where('public_path', $path)->exists());

        unlink(PersistedUpload::absolutePath($path));
        $this->assertFileDoesNotExist(PersistedUpload::absolutePath($path));
        $this->assertTrue(PersistedUpload::isAvailable($path));

        $this->assertSame(1, PersistedUpload::restoreAll());
        $this->assertFileExists(PersistedUpload::absolutePath($path));
        $this->assertNotSame('', AdultServiceCatalog::usableImageUrl($path));
    }

    public function test_encoded_file_names_are_not_encoded_twice(): void
    {
        $url = AdultServiceCatalog::publicImageUrl('/images/Italian%20braid.jpeg');
        $this->assertStringContainsString('Italian%20braid.jpeg', $url);
        $this->assertStringNotContainsString('Italian%2520braid.jpeg', $url);
        $this->assertSame('/images/Italian braid.jpeg', PersistedUpload::normalize('/images/Italian%20braid.jpeg'));
    }

    public function test_upload_temp_folder_is_ready(): void
    {
        $path = \App\Support\UploadTempDir::ensure();
        $this->assertNotSame('', $path);
        $this->assertDirectoryExists($path);
        $this->assertTrue(is_writable($path));
    }

    public function test_missing_saved_photo_falls_back_to_empty_so_bundled_cards_can_show(): void
    {
        $this->assertSame('', AdultServiceCatalog::usableImageUrl('/storage/service-images/missing.png'));
    }
}
