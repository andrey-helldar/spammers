<?php

namespace Helldar\Spammers\Middleware;

use Illuminate\Http\Request;

class Spammers
{
    /**
     * @var string
     */
    private $message = 'Current IP-address founded in spam base';

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        $ip = $request->ip();

        if (spammer($ip)->exists()) {
            if ($request->isJson() || $request->wantsJson()) {
                return response()->json($this->message, 423);
            }

            abort(423, $this->message);
        }

        return $next($request);
    }
}
