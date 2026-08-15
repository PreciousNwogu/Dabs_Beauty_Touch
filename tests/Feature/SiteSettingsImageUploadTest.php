<?php

namespace Tests\Feature;

use App\Models\User;
use App\Support\SiteSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class SiteSettingsImageUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        $dir = public_path('images/site');
        if (is_dir($dir)) {
            foreach (File::files($dir) as $file) {
                @unlink($file->getPathname());
            }
        }

        parent::tearDown();
    }

    public function test_admin_can_upload_promo_and_hero_images_via_data_url(): void
    {
        $admin = User::factory()->admin()->create();

        $png1x1 = base64_encode(hex2bin(
            '89504e470d0a1a0a0000000d49484452000000010000000108060000001f15c4890000000a49444154789c63000100000500010d0a2db40000000049454e44ae426082'
        ));

        $this->actingAs($admin)
            ->put('/admin/settings', [
                'interac_email' => 'deposit@example.com',
                'interac_amount' => 20,
                'max_bookings_per_day' => 2,
                'finished_tip_amount' => 20,
                'front_back_amount' => 20,
                'promo_enabled' => 1,
                'promo_title' => 'Promo',
                'promo_text' => 'Hello',
                'promo_image_data' => 'data:image/png;base64,'.$png1x1,
                'hero_image_data' => 'data:image/png;base64,'.$png1x1,
            ])
            ->assertRedirect(route('admin.settings.edit'))
            ->assertSessionHasNoErrors();

        SiteSettings::clearCache();

        $promoPath = (string) SiteSettings::get('promo_image');
        $heroPath = (string) SiteSettings::get('hero_image');

        $this->assertStringStartsWith('/images/site/', $promoPath);
        $this->assertStringStartsWith('/images/site/', $heroPath);
        $this->assertFileExists(public_path(ltrim($promoPath, '/')));
        $this->assertFileExists(public_path(ltrim($heroPath, '/')));
        $this->assertStringContainsString('/images/site/', SiteSettings::promoImageUrl());
        $this->assertStringContainsString('/images/site/', SiteSettings::heroImageUrl());
    }
}
