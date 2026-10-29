<?php

namespace Tests\Feature;

use Tests\TestCase;

class BugFixesAuditTest extends TestCase
{
    /**
     * Test 1: Verify Cart Container ID matches between HTML and JS.
     */
    public function test_cart_drawer_container_id_is_synchronized(): void
    {
        $blade = file_get_contents(resource_path('views/app.blade.php'));
        
        $this->assertStringContainsString('id="cartItemsList"', $blade);
        $this->assertStringContainsString("document.getElementById('cartItemsList')", $blade);
    }

    /**
     * Test 2: Verify View Mode Grid and List buttons exist and are referenced properly.
     */
    public function test_view_mode_buttons_are_correctly_targeted(): void
    {
        $blade = file_get_contents(resource_path('views/app.blade.php'));
        
        $this->assertStringContainsString('id="viewBtnGrid"', $blade);
        $this->assertStringContainsString('id="viewBtnList"', $blade);
        $this->assertStringContainsString("document.getElementById('viewBtnGrid')", $blade);
        $this->assertStringContainsString("document.getElementById('viewBtnList')", $blade);
    }

    /**
     * Test 3: Verify Phone OTP handlers are defined and tab switching covers OTP.
     */
    public function test_phone_otp_client_functions_are_defined(): void
    {
        $blade = file_get_contents(resource_path('views/app.blade.php'));
        
        $this->assertStringContainsString('async function handleSendOtp()', $blade);
        $this->assertStringContainsString('async function handleVerifyOtp()', $blade);
        $this->assertStringContainsString('function resetOtpStep()', $blade);
        $this->assertStringContainsString('function fillQuickOtpPhone(', $blade);
        $this->assertStringContainsString("tab === 'otp'", $blade);
    }

    /**
     * Test 4: Verify health route has zero duplicates inside v1 group and root alias.
     */
    public function test_no_duplicate_health_route_in_api(): void
    {
        $apiRoutes = file_get_contents(base_path('routes/api.php'));
        
        // Extract v1 group
        preg_match("/Route::prefix\('v1'\)->group\(function \(\) \{(.*?)\}\);/s", $apiRoutes, $v1Matches);
        $this->assertNotEmpty($v1Matches);
        $v1Group = $v1Matches[1];
        
        $v1Count = substr_count($v1Group, "Route::get('health'");
        $this->assertSame(1, $v1Count, "Route::get('health') must only be registered once inside v1 prefix group.");

        // Root unversioned alias
        $rootRoutes = str_replace($v1Matches[0], '', $apiRoutes);
        $rootCount = substr_count($rootRoutes, "Route::get('health'");
        $this->assertSame(1, $rootCount, "Route::get('health') unversioned alias must only be registered once.");
    }

    /**
     * Test 5: Verify mobile bottom nav labels are bilingual in translation maps.
     */
    public function test_mobile_bottom_nav_labels_have_bilingual_parity(): void
    {
        $blade = file_get_contents(resource_path('views/app.blade.php'));
        
        $requiredKeys = ['lblMobAll', 'lblMobLive', 'lblMobSell', 'lblMobStore', 'lblMobAccount'];
        foreach ($requiredKeys as $key) {
            $this->assertStringContainsString("{$key}:", $blade);
        }
    }
}
