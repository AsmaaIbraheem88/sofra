<?php

namespace App\Http\Middleware;

use Closure;

class CheckCommissions
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
        if(($request->user()->total_commissions - $request->user()->total_payments) > 400)
        {
            return responseJson('0','يرجي مراجعه صفحه العموله او مراجعه اداره التطبيق');
        }
        return $next($request);
    }
}
