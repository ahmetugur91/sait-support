<?php

namespace App\Http\Middleware;

use App\User;
use Carbon\Carbon;
use Closure;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // request de token olacak ve bu tokenin zamanı geçmemiş olacak.
        if ($request->has("token") && User::where("token",$request->token)->where("token_expire", ">", Carbon::now() )->exists() ) {
            return $next($request);
        } else {
            return response()->json(['status' => "unauthorized"])->setStatusCode(401); // 401 Unauthorized, belki 200 de yapabilirsin sana kalmış
        }
    }
}
