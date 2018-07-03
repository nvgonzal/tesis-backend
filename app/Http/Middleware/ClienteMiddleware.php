<?php

namespace App\Http\Middleware;

use Closure;

class ClienteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->tipo_usuario == 'cliente') {
            return $next($request);
        }
        return response()->json(['message'=>'No estas autorizado'],403);
    }
}
