<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EhPsicologo
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->ehPsicologo()) {
            abort(403, 'Acesso restrito a psicólogos.');
        }

        return $next($request);
    }
}
