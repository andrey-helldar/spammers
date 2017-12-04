<?php

namespace Helldar\Spammers\Middleware;

class Spammers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $is_spammer = spammer($request->getClientIp())->exists();

        if ($request->isJson() || $request->wantsJson()) {
            return response()->json('Current IP-address founded in spam base.', 403);
        }

        abort_if($is_spammer, 403);

        return $next($request);
    }
}
