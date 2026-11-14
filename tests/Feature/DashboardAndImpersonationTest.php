<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Order;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardAndImpersonationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Rivaaj');
        $response->assertSee('Sign In');
    }

    public function test_admin_can_login_and_access_admin_dashboard(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Executive Operations Overview');
    }

    public function test_employee_cannot_access_admin_dashboard(): void
    {
        $employee = User::where('role', 'employee')->first();

        $response = $this->actingAs($employee)->get('/admin/dashboard');
        $response->assertRedirect('/employee/dashboard');
    }

    public function test_employee_can_access_employee_dashboard(): void
    {
        $employee = User::where('role', 'employee')->first();

        $response = $this->actingAs($employee)->get('/employee/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Staff Workspace & Shift Hub');
    }

    public function test_admin_can_shadow_impersonate_employee_and_return(): void
    {
        $admin = User::where('role', 'admin')->first();
        $employee = User::where('role', 'employee')->first();

        // 1. Admin triggers shadow mode
        $response = $this->actingAs($admin)->post("/admin/impersonate/{$employee->id}");
        $response->assertRedirect('/employee/dashboard');
        $response->assertSessionHas('admin_impersonator_id', $admin->id);

        // 2. Now viewing employee dashboard with banner
        $response = $this->withSession(['admin_impersonator_id' => $admin->id])
                         ->actingAs($employee)
                         ->get('/employee/dashboard');
        $response->assertStatus(200);
        $response->assertSee('ADMIN SHADOW MODE ACTIVE');
        $response->assertSee('Return to Admin Dashboard');

        // 3. Admin clicks return
        $leaveResponse = $this->withSession(['admin_impersonator_id' => $admin->id])
                              ->actingAs($employee)
                              ->post('/impersonate/leave');
        $leaveResponse->assertRedirect('/admin/employees');
        $this->assertEquals($admin->id, auth()->id());
    }

    public function test_admin_can_kick_and_reactivate_employee(): void
    {
        $admin = User::where('role', 'admin')->first();
        $employee = User::where('role', 'employee')->first();

        // Admin kicks employee
        $kickResponse = $this->actingAs($admin)->post("/admin/employees/{$employee->id}/kick", [
            'kick_reason' => 'Violation of packaging standards',
        ]);
        $kickResponse->assertRedirect('/admin/employees');

        $employee->refresh();
        $this->assertEquals('kicked', $employee->status);
        $this->assertEquals('Violation of packaging standards', $employee->kick_reason);

        // Kicked employee tries to access dashboard -> blocked
        $blockedResponse = $this->actingAs($employee)->get('/employee/dashboard');
        $blockedResponse->assertRedirect('/login');

        // Admin unkicks/reactivates employee
        $unkickResponse = $this->actingAs($admin)->post("/admin/employees/{$employee->id}/kick");
        $unkickResponse->assertRedirect('/admin/employees');

        $employee->refresh();
        $this->assertEquals('active', $employee->status);
        $this->assertNull($employee->kick_reason);
    }

    public function test_admin_and_employee_can_add_product(): void
    {
        $admin = User::where('role', 'admin')->first();

        // 1. Admin adds product
        $response = $this->actingAs($admin)->post('/admin/products', [
            'title' => 'Rosemary Miracle Mist',
            'category' => 'serum',
            'price' => 1950,
            'original_price' => 2500,
            'volume' => '100ml',
            'stock' => 80,
            'badge' => 'HOT SELLER',
        ]);
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('products', ['title' => 'Rosemary Miracle Mist']);

        // 2. View on public store
        $storeResponse = $this->get('/products');
        $storeResponse->assertStatus(200);
        $storeResponse->assertSee('Rosemary Miracle Mist');

        // 3. Employee adds product
        $employee = User::where('role', 'employee')->first();
        $empResponse = $this->actingAs($employee)->post('/employee/products', [
            'title' => 'Kalonji Black Seed Elixir',
            'category' => 'hair-oil',
            'price' => 2200,
            'original_price' => 2800,
            'volume' => '150ml',
            'stock' => 50,
            'badge' => 'ORGANIC',
        ]);
        $empResponse->assertSessionHas('success');
        $this->assertDatabaseHas('products', ['title' => 'Kalonji Black Seed Elixir']);
    }

    public function test_public_navbar_does_not_show_admin_label(): void
    {
        $admin = User::where('role', 'admin')->first();

        // Even when admin is logged in and visits store front
        $response = $this->actingAs($admin)->get('/');
        $response->assertStatus(200);
        // Website navbar should NOT expose Admin badge/label
        $response->assertDontSee('<span>Admin</span>', false);
    }
}
