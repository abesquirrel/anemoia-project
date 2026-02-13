<?php

namespace Tests\Feature\Admin;

use App\Models\Setting;
use App\Models\SocialPlatform;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SocialEnhancementsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true]);

        // Ensure default setting exists without duplicating if migration already ran
        Setting::updateOrCreate(
            ['key' => 'social_share_enabled'],
            ['value' => '1']
        );
    }

    public function test_admin_can_toggle_global_social_share()
    {
        $response = $this->actingAs($this->admin)
            ->patch(route('admin.social-platforms.toggle-global'), [
                'social_share_enabled' => 0
            ]);

        $response->assertRedirect();
        $this->assertEquals('0', Setting::get('social_share_enabled'));
    }

    public function test_admin_can_reorder_social_platforms()
    {
        $p1 = SocialPlatform::factory()->create(['sort_order' => 10]);
        $p2 = SocialPlatform::factory()->create(['sort_order' => 20]);

        $response = $this->actingAs($this->admin)
            ->patchJson(route('admin.social-platforms.reorder'), [
                'order' => [$p2->id, $p1->id]
            ]);

        $response->assertStatus(200);
        $this->assertEquals(10, $p2->fresh()->sort_order);
        $this->assertEquals(20, $p1->fresh()->sort_order); // (index+1)*10 -> (1+1)*10 = 20
        // My Logic was: foreach ($request->order as $index => $id) { update sort_order to ($index + 1) * 10 }
        // $index 0 (p2) -> 10
        // $index 1 (p1) -> 20
        // Correct.
    }

    public function test_social_share_component_respects_global_toggle()
    {
        SocialPlatform::factory()->create(['is_active' => true]);

        // 1. Enabled
        $view = $this->view('components.social-share', [
            'url' => 'http://test.com',
            'title' => 'Test'
        ]);
        $view->assertSee('social-share-buttons');

        // 2. Disabled
        Setting::where('key', 'social_share_enabled')->update(['value' => '0']);

        $view = $this->view('components.social-share', [
            'url' => 'http://test.com',
            'title' => 'Test'
        ]);
        $view->assertDontSee('social-share-buttons');
    }
}
