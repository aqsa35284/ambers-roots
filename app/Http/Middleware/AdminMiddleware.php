<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access the Admin Dashboard.');
        }

        $user = Auth::user();

        // Check if kicked
        if ($user->status === 'kicked') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Your account has been kicked or suspended by the Administrator.');
        }

        // Allow admin and employee roles
        if (!in_array($user->role, ['admin', 'employee'])) {
            return redirect()->route('login')->with('error', 'Access denied. You do not have authorized privileges.');
        }

        return $next($request);
    }
}
