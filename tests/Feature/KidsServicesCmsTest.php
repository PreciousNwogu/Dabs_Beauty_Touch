<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use App\Support\KidsStyleCatalog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KidsServicesCmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_create_form_can_open_as_kids_style(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.services.create', ['for_kids' => 1]))
            ->assertOk()
            ->assertSee('For Kids')
            ->assertSee('checked', false);
    }

    public function test_admin_can_create_a_kids_style_like_an_adult_service(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.services.store'), [
                'name' => 'Kids Lemonade Braids',
                'base_price' => 95,
                'description' => 'Sweet lemonade parts for little ones.',
                'duration' => '2–3 hrs',
                'is_active' => 1,
                'for_kids' => 1,
                'has_length' => 1,
            ])
            ->assertRedirect(route('admin.services.index'));

        $service = Service::query()->where('name', 'Kids Lemonade Braids')->first();
        $this->assertNotNull($service);
        $this->assertTrue((bool) $service->for_kids);
        $this->assertSame('Kids Braids', $service->category);
        $this->assertTrue((bool) $service->has_length);
        $this->assertSame('2–3 hrs', $service->duration);
        $this->assertSame('Sweet lemonade parts for little ones.', $service->description);

        $this->get('/kids-selector')
            ->assertOk()
            ->assertSee('Kids Lemonade Braids')
            ->assertSee('Sweet lemonade parts for little ones.')
            ->assertSee('2–3 hrs')
            ->assertSee('cms_'.$service->id, false);
    }

    public function test_admin_can_edit_a_built_in_kids_style_and_the_selector_updates(): void
    {
        $admin = User::factory()->admin()->create();
        KidsStyleCatalog::ensureCmsServices();
        $service = Service::query()->where('slug', 'protective')->first();
        $this->assertNotNull($service);

        $this->actingAs($admin)
            ->put(route('admin.services.update', $service), [
                'name' => 'Kids Soft Twists',
                'slug' => 'protective',
                'base_price' => 85,
                'description' => 'Soft twists, no extensions.',
                'duration' => '45 min',
                'is_active' => 1,
                'for_kids' => 1,
                'has_length' => 0,
            ])
            ->assertRedirect(route('admin.services.index'));

        $this->get('/kids-selector')
            ->assertOk()
            ->assertSee('Kids Soft Twists')
            ->assertSee('Soft twists, no extensions.')
            ->assertSee('45 min')
            ->assertSee('data-disable-steps="1"', false);
    }

    public function test_hiding_a_built_in_kids_style_keeps_the_row_and_removes_the_card(): void
    {
        $admin = User::factory()->admin()->create();
        KidsStyleCatalog::ensureCmsServices();
        $service = Service::query()->where('slug', 'cornrows')->first();
        $this->assertNotNull($service);

        $this->actingAs($admin)
            ->delete(route('admin.services.destroy', $service))
            ->assertRedirect(route('admin.services.index'));

        $service->refresh();
        $this->assertFalse((bool) $service->is_active);

        $this->get('/kids-selector')
            ->assertOk()
            ->assertDontSee('kb_type_cornrows', false);
    }

    public function test_homepage_kids_card_uses_previous_photo_and_lowest_price(): void
    {
        KidsStyleCatalog::ensureCmsServices();
        $lowest = KidsStyleCatalog::lowestVisiblePrice();
        $this->assertSame(50, $lowest);

        $this->get('/')
            ->assertOk()
            ->assertSee('kids hair style.webp', false)
            ->assertSee('$'.$lowest);
    }

    public function test_admin_services_filter_includes_kids_braids_category(): void
    {
        $admin = User::factory()->admin()->create();
        KidsStyleCatalog::ensureCmsServices();

        $this->actingAs($admin)
            ->get(route('admin.services.index'))
            ->assertOk()
            ->assertSee('filterCategory', false)
            ->assertSee('<option value="Kids Braids">Kids Braids</option>', false);

        $this->actingAs($admin)
            ->get(route('admin.services.create'))
            ->assertOk()
            ->assertDontSee('<option value="Kids Braids">Kids Braids</option>', false);
    }

    public function test_hyphenated_kids_slugs_do_not_duplicate_selector_cards(): void
    {
        KidsStyleCatalog::ensureCmsServices();
        $box = Service::query()->where('name', 'Kids Box Braids Small')->first();
        $knotless = Service::query()->where('name', 'Kids Knotless Small')->first();
        $this->assertNotNull($box);
        $this->assertNotNull($knotless);

        $box->update(['slug' => 'box-small']);
        $knotless->update(['slug' => 'knotless-small']);

        $keys = collect(KidsStyleCatalog::selectorCards())->pluck('key');
        $this->assertSame(1, $keys->filter(fn ($k) => $k === 'box_small')->count());
        $this->assertSame(1, $keys->filter(fn ($k) => $k === 'knotless_small')->count());
        $this->assertFalse($keys->contains('cms_'.$box->id));
        $this->assertFalse($keys->contains('cms_'.$knotless->id));

        KidsStyleCatalog::ensureCmsServices();
        $this->assertSame('box_small', $box->fresh()->slug);
        $this->assertSame('knotless_small', $knotless->fresh()->slug);
    }

    public function test_adult_cornrow_weave_slug_is_not_treated_as_a_kids_style(): void
    {
        $this->assertNull(KidsStyleCatalog::canonicalSlug('cornrow-weave'));
        $this->assertNull(KidsStyleCatalog::canonicalSlug('stitch-braids'));
        $this->assertSame('cornrow_weave', KidsStyleCatalog::canonicalSlug('kids-cornrow-weave'));
        $this->assertSame('stitch', KidsStyleCatalog::canonicalSlug('kids-stitch-braids'));
    }

    public function test_admin_can_update_adult_cornrow_and_stitch_photos_while_kids_styles_exist(): void
    {
        $admin = User::factory()->admin()->create();
        KidsStyleCatalog::ensureCmsServices();

        $cornrowWeave = Service::query()->create([
            'name' => 'Cornrow Weave',
            'slug' => 'cornrow-weave',
            'base_price' => 100,
            'is_active' => true,
            'for_kids' => false,
            'category' => 'Cornrow/Feed-in Braids',
        ]);
        $stitchBraids = Service::query()->create([
            'name' => 'Stitch Braids',
            'slug' => 'stitch-braids',
            'base_price' => 120,
            'is_active' => true,
            'for_kids' => false,
            'category' => 'Cornrow/Feed-in Braids',
        ]);

        $this->actingAs($admin)
            ->get('/admin/services/'.$cornrowWeave->id)
            ->assertRedirect(route('admin.services.edit', $cornrowWeave));

        $this->actingAs($admin)
            ->get(route('admin.services.edit', $cornrowWeave))
            ->assertOk();

        $this->actingAs($admin)
            ->put(route('admin.services.update', $cornrowWeave), [
                'name' => 'Cornrow Weave',
                'slug' => 'cornrow-weave',
                'base_price' => 100,
                'is_active' => 1,
                'image_url' => '/images/cornrow-weave.jpg',
            ])
            ->assertRedirect(route('admin.services.index'))
            ->assertSessionHasNoErrors();

        $this->actingAs($admin)
            ->put(route('admin.services.update', $stitchBraids), [
                'name' => 'Stitch Braids',
                'slug' => 'stitch-braids',
                'base_price' => 120,
                'is_active' => 1,
                'image_url' => '/images/stitch braid.jpg',
            ])
            ->assertRedirect(route('admin.services.index'))
            ->assertSessionHasNoErrors();

        $this->assertSame('cornrow-weave', $cornrowWeave->fresh()->slug);
        $this->assertSame('stitch-braids', $stitchBraids->fresh()->slug);
        $this->assertFalse((bool) $cornrowWeave->fresh()->for_kids);
        $this->assertSame('/images/cornrow-weave.jpg', $cornrowWeave->fresh()->image_url);
        $this->assertSame('/images/stitch braid.jpg', $stitchBraids->fresh()->image_url);

        $kidsCornrow = Service::query()->where('slug', 'cornrow_weave')->first();
        $kidsStitch = Service::query()->where('slug', 'stitch')->first();
        $this->assertNotNull($kidsCornrow);
        $this->assertNotNull($kidsStitch);
        $this->assertTrue((bool) $kidsCornrow->for_kids);
        $this->assertTrue((bool) $kidsStitch->for_kids);
    }
}
