<?php

namespace App\Http\Middleware;

use Closure;

class DuenoMiddleware
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
        if ($request->user()->tipo_usuario == 'dueño') {
            return $next($request);
        }
        return response()->json(['message'=>'No estas autorizado'],403);
    }
}
