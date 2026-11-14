<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckKickedMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $isImpersonating = $request->session()->has('admin_impersonator_id');

            if ($user->status === 'kicked' && !$isImpersonating) {
                $reason = $user->kick_reason ?: 'Administrator has revoked your account access.';
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('error', 'ACCOUNT SUSPENDED: ' . $reason);
            }
        }

        return $next($request);
    }
}
