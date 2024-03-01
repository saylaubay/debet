<?php

namespace App\Http\Middleware;

use App\Http\Controllers\BaseController;
use App\Models\ApiResponse;
use Closure;
use Illuminate\Http\Request;

class Admin
{
    public $baseController;

    public function __construct(BaseController $baseController)
    {
        $this->baseController = $baseController;
    }


    public function handle(Request $request, Closure $next)
    {
//        if (auth()->user()->role->name != "ADMIN"){
////            abort(403, "Sizdin' bunday huqiqin`iz joq!!!");
//            return $this->baseController->response(new ApiResponse("Admin middleware test", false));
//        }
        $cars = array("SUPER_ADMIN", "ADMIN");
        if (auth()->user()->role->name == "ADMIN" || auth()->user()->role->name != "SUPER_ADMIN") {
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
