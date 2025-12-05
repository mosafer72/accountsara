<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        dd($user->isAdmin());
        if (!$user) {
            return $next($request);
        }

        if ($user->isAdmin() >= 1) {
            return $next($request);
        }else{
           abort(404);
        }
    }
}
