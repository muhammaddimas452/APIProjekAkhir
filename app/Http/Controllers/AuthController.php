<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validate->fails()){
            $respons = [
                'status'    => 'error',
                'msg'       => 'Validator error',
                'errors'    => $validate->errors(),
                'content'   => null,
            ];
            return response()->json($respon, 200);
        }else{
            $credentials    = request(['email', 'password']);
            $credentials    = Arr::add($credentials, 'status', 'aktif');
            if(!Auth::attempt($credentials)){
                $respons = [
                    'status'    => 'error',
                    'msg'       => 'Unathorized',
                    'errors'    => null,
                    'content'   => null,
                ];
                return response()->json($respons, 401);
            }

            $user   = User::where('email', $request->email)->first();
            if(! Hash::check($request->password, $user->password, [])){
                throw new Exception('Error in login');
            }

            $tokenResult = $user->createToken('token-auth')->plainTextToken;
             $respons = [
                    'status'    => 'success',
                    'msg'       => 'Login Successfully',
                    'errors'    => null,
                    'content'   => [
                        'status_code'   => 200,
                        'access_token'  => $tokenResult,
                        'token_type'    => 'Bearer',
                    ],
                ];
                return response()->json($respons, 200);
        }
    }
}
