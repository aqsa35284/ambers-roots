<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Ensure initial seed data exists in DB if empty.
     */
    protected function ensureInitialData(): void
    {
        try {
            if (User::where('role', 'admin')->count() === 0) {
                (new DatabaseSeeder())->run();
            }
        } catch (\Throwable $e) {
            // Silently handle if table not ready
        }
    }

    /**
     * Show login form.
     */
    public function showLoginForm()
    {
        $this->ensureInitialData();

        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('employee.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Process login request.
     */
    public function login(Request $request)
    {
        $this->ensureInitialData();

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withInput($request->only('email'))->with('error', 'Invalid email or password. Please try again.');
        }

        // Check if employee is kicked
        if ($user->status === 'kicked') {
            return back()->withInput($request->only('email'))->with(
                'error',
                'Your account has been suspended or kicked by the Administrator.' . ($user->kick_reason ? " Reason: {$user->kick_reason}" : '')
            );
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Update last active
        $user->update(['last_active_at' => now()]);

        // Activity log
        ActivityLog::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'action' => 'login',
            'details' => "User {$user->name} ({$user->role}) logged in.",
            'ip_address' => $request->ip(),
        ]);

        if ($user->role === 'admin' || $user->role === 'employee') {
            return redirect()->route('admin.dashboard')->with('success', 'Welcome to Store Operations Dashboard!');
        }

        return redirect()->route('home');
    }

    /**
     * Process logout request.
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        // Clear any impersonation state
        $request->session()->forget('admin_impersonator_id');

        if ($user) {
            ActivityLog::create([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'action' => 'logout',
                'details' => "User {$user->name} logged out.",
                'ip_address' => $request->ip(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been successfully logged out.');
    }
}
