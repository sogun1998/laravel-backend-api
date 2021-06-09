<?php

namespace App\Http\Middleware;

use Closure;

class PhuhuynhTokenValidate
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
        if (!$request->user()->tokenCan('phuhuynh')) {
            return response()->json([
                'message' => "Unauthenticated",
                'status_code'=>401 ,
            ]);
        }

        return $next($request);
    }
}
