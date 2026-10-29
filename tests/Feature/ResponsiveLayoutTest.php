<?php

namespace Tests\Feature;

use Tests\TestCase;

class ResponsiveLayoutTest extends TestCase
{
    /**
     * Test viewport, mobile meta tags, and PWA capabilities.
     */
    public function test_mobile_and_tab_viewport_meta_tags_exist(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('viewport-fit=cover', false);
        $response->assertSee('theme-color', false);
        $response->assertSee('apple-mobile-web-app-capable', false);
    }

    /**
     * Test smooth sticky navigation on mobile/tablet without bar collision.
     */
    public function test_nav_is_sticky_at_top_zero_for_mobile_screens(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('sticky top-0 z-40', false);
    }

    /**
     * Test native mobile bottom navigation bar exists with thumb-friendly buttons.
     */
    public function test_native_mobile_bottom_navigation_bar_rendered(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('id="mobileBottomNav"', false);
        $response->assertSee('md:hidden fixed bottom-0', false);
        $response->assertSee('id="mobNavAll"', false);
        $response->assertSee('id="mobNavLive"', false);
        $response->assertSee('id="mobNavSell"', false);
        $response->assertSee('id="mobNavStore"', false);
        $response->assertSee('id="mobNavAccount"', false);
    }

    /**
     * Test responsive category pills and horizontal touch-scroll.
     */
    public function test_category_pills_touch_scrollable(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('touch-scroll-x', false);
        $response->assertSee('id="categoriesBar"', false);
    }

    /**
     * Test technical care hub has 2-col on mobile, 3-col on tab, 6-col on desktop.
     */
    public function test_technical_care_hub_responsive_grid(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6', false);
        $response->assertSee('id="btnHubPassport"', false);
        $response->assertSee('id="btnHubMigration"', false);
        $response->assertSee('id="btnHubNutrition"', false);
        $response->assertSee('id="btnHubClinical"', false);
        $response->assertSee('id="btnHubWoolLab"', false);
    }

    /**
     * Test safe bottom padding exists so bottom navigation does not obscure page footer.
     */
    public function test_safe_bottom_padding_applied(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('safe-bottom-padding', false);
    }

    /**
     * Test marketing video short simulator route is accessible and responsive.
     */
    public function test_marketing_video_short_view_is_responsive(): void
    {
        $response = $this->get('/marketing-short');

        $response->assertStatus(200);
        $response->assertSee('Kashmir Sheeps Viral Short (9:16)', false);
        $response->assertSee('phone-glow', false);
    }
}
