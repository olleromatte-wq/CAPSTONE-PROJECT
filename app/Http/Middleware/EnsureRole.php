<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->session()->has('user') || ! in_array($request->session()->get('user.role'), $roles, true)) {
            return redirect()->route('login')->withErrors(['login' => 'Please sign in with an authorized account.']);
        }

        return $next($request);
    }
}
