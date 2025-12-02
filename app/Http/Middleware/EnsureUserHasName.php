<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasName
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (!$user) {
            return $next($request);
        }

        if ($request->routeIs('user.profile.edit', 'user.panel')) {
            return $next($request);
        }

        if (!filled(trim($user->name))) {

            // 🔹 نسخه معمولی (ری‌دایرکت)
            return redirect()
                ->route('admin.dashboard')
                ->with('warning', 'لطفا نام خود را وارد کنید');
        }

        return $next($request);
    }
}
