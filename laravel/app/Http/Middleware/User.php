<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is logged in and if the role is not user
        if (Auth::check() && Auth::user()->role != 'user') {
            // If accessing 'student-dashboard', return 403 Unauthorized
            if ($request->is('student-dashboard')) {
                abort(403, 'Unauthorized action.');
            }
            // Redirect to the admin dashboard if the user is not a student
            return redirect('dashboard');
        }
        return $next($request);
    }
    

}
