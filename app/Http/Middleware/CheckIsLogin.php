<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsLogin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth()->check()) { // Menggunakan helper function auth()
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu!');
        }

        return $next($request);
    }
}
