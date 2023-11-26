<?php

namespace App\Http\Middleware;

use Closure;

class IsSuperAdmin
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
        if (auth()->user()->is_admin != 1 && (auth()->user()->email != 'danielamontechiaregentil@gmail.com' || auth()->user()->email != 'dev.anderson.santos@gmail.com')) {
            abort(403, 'Acesso negado');
        }

        return $next($request);
    }
}
