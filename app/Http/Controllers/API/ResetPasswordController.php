<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;


class ResetPasswordController extends Controller
{
    protected function sendResetResponse(Request $request)
    {
        //password.reset
        $input = $request->only('token', 'password', 'password_confirmation');
        $validator = Validator::make($input, [
        'token' => 'required',
        // 'email' => 'required|email',
        'password' => 'required|confirmed|min:8',
        ]);
        if ($validator->fails()) {
        return response(['errors'=>$validator->errors()->all()], 422);
        }
        $response = Password::reset($input, function ($user, $password) {
        $user->forceFill([
        'password' => Hash::make($password)
        ])->save();
        $user->setRememberToken(Str::random(60));
        event(new PasswordReset($user));
        });
        if($response == Password::PASSWORD_RESET){
        $message = "Password reset successfully";
        $status = "200";
        }else{
        $message = "Email could not be sent to this email address";
        $status = "500";
        }
        $response = [
            'data'      =>'', 
            'message'   => $message,
            'status'    => $status
        ];
        return response()->json($response);
    }
}
