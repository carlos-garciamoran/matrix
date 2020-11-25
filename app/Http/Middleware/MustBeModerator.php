<?php

namespace App\Http\Middleware;

use Closure;

class MustBeModerator
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
        abort_unless(app('user')->moderator, 403);

        return $next($request);
    }
}
