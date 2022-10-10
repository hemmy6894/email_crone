<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AcceptRefereralMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $accepts = [
            "http://jamaap.grandtracks.com/"
        ];
        $ref = $request->headers->get('referer');
        if(!in_array($ref,$accepts)){
            abort(404);
        }
        return $next($request);
    }
}
