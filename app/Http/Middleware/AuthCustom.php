<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthCustom
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('id')) {
            return redirect()->route('login'); // ajusta a tu ruta de login real
        }

        return $next($request);
    }
}
