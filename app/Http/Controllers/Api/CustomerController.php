<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    private $user;

    public function __construct(Request $request)
    {
        // Middleware kontrolünü geçtikten sonra useri classın içinde member olarak tanımlıyorum.
        $this->user = User::where("token", $request->token)->first();
    }

    public function me(Request $request)
    {
        return $this->user;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => 'validation_error',
                "messages" => $validator->messages()
            ], 200);
        }

        return Customer::create([
            "name" => $request->name,
            "surname" => $request->surname,
            "email" => $request->email,
        ]);
    }
}
