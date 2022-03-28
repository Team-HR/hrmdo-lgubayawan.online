<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Prophecy\Argument\Token\InArrayToken;
use App\Providers\RouteServiceProvider;

class IsRsmEditor
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

        $roles = json_decode(isset(auth()->user()->roles)?auth()->user()->roles:"[]");
        if (!in_array("rsm", $roles)) {
            // return redirect(RouteServiceProvider::HOME);
            // return response()->json(['error' => 'forbidden'], 403);
            abort(response()->json(
                [
                    'api_status' => '403',
                    'message' => 'Forbidden',
                ], 403));
        }
        return $next($request);
    }
}
