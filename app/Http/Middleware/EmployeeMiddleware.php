<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EmployeeMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access the Employee Dashboard.');
        }

        $user = Auth::user();
        $isImpersonating = $request->session()->has('admin_impersonator_id');

        // Check if employee is kicked (and not an admin inspecting via shadow mode)
        if ($user->status === 'kicked' && !$isImpersonating) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Your employee account has been suspended or kicked by the Administrator. Access revoked.');
        }

        // Allow if role is employee OR admin OR if impersonating
        if ($user->role !== 'employee' && $user->role !== 'admin' && !$isImpersonating) {
            return redirect()->route('home')->with('error', 'Access restricted to authorized employees.');
        }

        return $next($request);
    }
}
