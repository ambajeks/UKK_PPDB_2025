<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class IsUser
{
    /**
     * Handle an incoming request.
     * Middleware ini memastikan hanya user dengan role "user" (calon siswa) yang bisa mengakses.
     * Admin akan di-redirect ke halaman 404.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Gate::allows('user')) {
            abort(404, 'Halaman tidak ditemukan');
        }

        return $next($request);
    }
}
