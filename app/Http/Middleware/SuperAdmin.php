<?php

namespace App\Http\Middleware;

use App\Models\ApiResponse;
use Closure;
use Illuminate\Http\Request;

class SuperAdmin
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
        if (auth()->user()->role->name == "SUPER_ADMIN") {
            return $next($request);
//            if (auth()->user()->role->name != "SUPER_ADMIN") {
//                return $this->baseController->response(new ApiResponse("SUPERAdmin middleware test", false));
//            }
//            else{
//            abort(403, "Sizdin' bunday huqiqin`iz joq!!!");
//            }
        }
        abort(403, "Sizdin' bunday huqiqin`iz joq!!!");
    }
}
