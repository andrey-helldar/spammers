<?php

namespace Helldar\Spammers\Middleware;

use Helldar\Spammers\Facade\Spammer;

class Spammers
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $is_spammer = (new Spammer($request->getClientIp()))->exists();

        if ($is_spammer && ($request->isJson() || $request->wantsJson())) {
            return response()->json('Current IP-address founded in spam base.', 403);
        }

        abort_if($is_spammer, 403);

        return $next($request);
    }
}
