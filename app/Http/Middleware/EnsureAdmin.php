<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/** The admin panel is for signed-in staff accounts (users.is_admin) only. */
class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user || ! $user->is_admin || $user->status !== 'active') {
            return redirect()->guest(route('admin.login'));
        }

        return $next($request);
    }
}
