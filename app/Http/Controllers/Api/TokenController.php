<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    public function getToken(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $token = Str::random(32);
            $newExpireDate = Carbon::now()->addHours(12)->format("Y-m-d H:i:s");

            $user = User::where("email",$request->email)->first();
            $user->token = $token;
            $user->token_expire = $newExpireDate;
            $user->save();

            return response()->json(["status" => 'correct', "token" => $token, "expire" => $newExpireDate]);
        }
        else {
            return response()->json(["status" => 'incorrect']);
        }
    }
}
