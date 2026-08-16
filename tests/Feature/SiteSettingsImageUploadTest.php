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
        $this->assertTrue(\App\Models\StoredImage::query()->where('public_path', $promoPath)->exists());
        $this->assertTrue(\App\Models\StoredImage::query()->where('public_path', $heroPath)->exists());
        $this->assertStringContainsString('/images/site/', SiteSettings::promoImageUrl());
        $this->assertStringContainsString('/images/site/', SiteSettings::heroImageUrl());
        $this->assertCount(1, SiteSettings::promoMedia());
        $this->assertSame('image', SiteSettings::promoMedia()[0]['type']);
    }

    public function test_admin_can_upload_multiple_promo_photos_and_videos(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->put('/admin/settings', [
                'interac_email' => 'deposit@example.com',
                'interac_amount' => 20,
                'max_bookings_per_day' => 2,
                'finished_tip_amount' => 20,
                'front_back_amount' => 20,
                'promo_enabled' => 1,
                'promo_title' => 'Hair',
                'promo_text' => 'Weekend special',
                'promo_files' => [
                    \Illuminate\Http\UploadedFile::fake()->image('promo-one.jpg', 24, 24),
                    \Illuminate\Http\UploadedFile::fake()->createWithContent('promo-clip.mp4', str_repeat("\0", 2048)),
                ],
            ])
            ->assertRedirect(route('admin.settings.edit'))
            ->assertSessionHasNoErrors();

        SiteSettings::clearCache();

        $media = SiteSettings::promoMedia();
        $this->assertCount(2, $media);
        $types = collect($media)->pluck('type')->sort()->values()->all();
        $this->assertSame(['image', 'video'], $types);

        $this->get('/')
            ->assertOk()
            ->assertSee('promoMediaStage', false)
            ->assertSee('promo-fx-fade', false)
            ->assertSee('<video', false);
    }

    public function test_promo_video_php_limit_shows_a_clear_error(): void
    {
        $admin = User::factory()->admin()->create();
        $temp = tempnam(sys_get_temp_dir(), 'promo');
        file_put_contents($temp, 'clip');

        $this->actingAs($admin)
            ->put('/admin/settings', [
                'interac_email' => 'deposit@example.com',
                'interac_amount' => 20,
                'max_bookings_per_day' => 2,
                'finished_tip_amount' => 20,
                'front_back_amount' => 20,
                'promo_files' => [
                    new \Illuminate\Http\UploadedFile($temp, 'clip.mp4', 'video/mp4', UPLOAD_ERR_INI_SIZE, true),
                ],
            ])
            ->assertSessionHasErrors('promo_files.0');

        $this->assertStringContainsString(
            'too large',
            session('errors')->first('promo_files.0')
        );
    }
}
