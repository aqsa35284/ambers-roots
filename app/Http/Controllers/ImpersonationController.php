<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    /**
     * Start impersonating an employee in shadow mode.
     * Stealth: No notification or change visible to the employee.
     */
    public function enter(Request $request, $id)
    {
        $admin = Auth::user();

        // Ensure caller is Admin
        if (!$admin || $admin->role !== 'admin') {
            abort(403, 'Only administrators can initiate employee shadow mode.');
        }

        $employee = User::findOrFail($id);

        if ($employee->id === $admin->id) {
            return back()->with('error', 'You cannot impersonate yourself.');
        }

        // Store original admin ID in session
        $request->session()->put('admin_impersonator_id', $admin->id);
        $request->session()->put('admin_impersonator_name', $admin->name);

        // Stealth logging in ActivityLog for audit only (Admin eyes only)
        ActivityLog::create([
            'user_id' => $admin->id,
            'user_name' => $admin->name,
            'action' => 'impersonate_start',
            'details' => "Admin {$admin->name} entered shadow mode into {$employee->name}'s ({$employee->email}) dashboard.",
            'ip_address' => $request->ip(),
        ]);

        // Login as the employee
        Auth::login($employee);

        return redirect()->route('employee.dashboard')->with('impersonation_notice', "You are now viewing the dashboard as {$employee->name}.");
    }

    /**
     * Leave impersonation and return back to Admin Dashboard.
     */
    public function leave(Request $request)
    {
        $adminId = $request->session()->get('admin_impersonator_id');

        if (!$adminId) {
            return redirect()->route('home');
        }

        $admin = User::find($adminId);

        if (!$admin || $admin->role !== 'admin') {
            $request->session()->forget(['admin_impersonator_id', 'admin_impersonator_name']);
            return redirect()->route('login');
        }

        $currentEmployee = Auth::user();

        // Log exit in audit
        ActivityLog::create([
            'user_id' => $admin->id,
            'user_name' => $admin->name,
            'action' => 'impersonate_end',
            'details' => "Admin {$admin->name} exited shadow mode from {$currentEmployee->name}'s dashboard and returned to Admin Portal.",
            'ip_address' => $request->ip(),
        ]);

        // Clear impersonator session tokens
        $request->session()->forget(['admin_impersonator_id', 'admin_impersonator_name']);

        // Log back in as admin
        Auth::login($admin);

        return redirect()->route('admin.employees')->with('success', "Returned safely to Admin Dashboard from {$currentEmployee->name}'s view.");
    }
}
