<?php

namespace App\Http\Middleware;

use App\Models\ApiResponse;
use Closure;
use Illuminate\Http\Request;

class User
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
        if (auth()->user()->role->name != "USER"){
//            abort(403, "Sizdin' bunday huqiqin`iz joq!!!");
            return $this->baseController->response(new ApiResponse("USER middleware test", false));

        }
        return $next($request);
    }
}
