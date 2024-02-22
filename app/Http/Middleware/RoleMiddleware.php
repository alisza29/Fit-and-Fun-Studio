<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role): Response
    {
        if (!$request->user() || !$request->user()->hasRole($role)) {
            // Redirect to a specific route if the user does not have the required role
            // return redirect('home');
            // Redirect user to a specific page or abort with an unauthorized status code
            abort(403, 'Unauthorized action.');
        }

        // if ($request->user()->role !== $role) {
        //     if ($request->user()->role == 'vendor') {
        //         return redirect()->route('vendor.dashboard');
        //     } elseif ($request->user()->role == 'admin') {
        //         return redirect()->route('admin.dashboard');
        //     } else {
        //         return redirect()->route('dashboard');
        //     }
        // }

        return $next($request);
    }
}
