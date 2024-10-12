<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginAPIRequest;
use App\Models\User;


class AuthController extends Controller
{
    public function Login(LoginApiRequest $request)
    {
        $user = User::where('email',$request->email)->first();

        if($user == null || !Hash::check($request->password, $user->password)){
            return response()->json([
                'email' => ['The provided credentials are incorrect.']
            ],404);
        }

        if(Auth::attempt(['email'=> $request->email,'password'=>$request->password])) {

            return response()->json([
                'token' => $user->createToken('API TOKEN')->plainTextToken,
                'profile' => $user,
                'message' => 'Login Successfull'
            ],200);
        }
    }

    public function logout(Request $request)
    {
       
        //Revoke the token 
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'message' => 'Logged out successfully',
        ], 200);

       
    }
}
