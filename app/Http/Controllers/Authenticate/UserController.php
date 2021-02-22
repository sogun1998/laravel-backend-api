<?php

namespace App\Http\Controllers\Authenticate;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function register(Request $request)
    {
        //VALIDATION HERE

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        //REGISTER NEW USER BY RECORDING NAME, PHONE
        return response()->json([
            'status_code'=>200,
            'message'=>'User registered successfully.',
            'data'=>[

            ]
        ]);
    }

    public function login(Request $request)
    {
        //VALIDATE PHONE NUMBER

        $user = User::where('email',$request->email)->first();

        if(!$user){
            return response()->json([
                'status_code'=>404  ,
                'message'=>'User does not exist.',
                'data'=>[

                ]
            ]);
        }

        if(!Hash::check($request->password,$user->password)){
            return response()->json([
                'status_code'=>401  ,
                'message'=>'Incorrect password',
                'data'=>[

                ]
            ]);
        }

        $user->OauthAcessToken()->where('name','user')->delete();
        $access_token = $user->createToken('user',['user'])->accessToken;
        //LOGIN

        //RETURN DATA WITH access_TOKEN
        return response()->json([
            'status_code'=>200 ,
            'message'=>'User has successfully logged in OTP.',
            'data'=>[
                'user'=>$user,
                'access_token'=>$access_token,
                'role'=>1
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->OauthAcessToken()->where('name','user')->delete();

        return response()->json([
            'status_code'=>200 ,
            'message'=>'Logout successful.',
            'data'=>[

            ]
        ]);
    }
    public function getUser(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'status_code'=>200 ,
            'data'=>$user,
            'role'=> 1
        ]);
    }

}
