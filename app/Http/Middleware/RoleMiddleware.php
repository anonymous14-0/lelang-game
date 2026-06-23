<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Middleware untuk membatasi akses halaman berdasarkan role pengguna.
class RoleMiddleware
{
    // Memeriksa autentikasi dan kecocokan role sebelum request dilanjutkan.
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Arahkan pengguna yang belum login ke halaman login.
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Tolak akses jika role pengguna tidak termasuk role yang diizinkan.
        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Akses Ditolak');
        }

        return $next($request);
    }
}