<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/** Mirrors the "$_SESSION['usermail']" guard on the original pages. */
class EnsureLoggedIn
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('usermail')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
