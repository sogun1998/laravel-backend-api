<?php

namespace App\Http\Controllers\Authenticate;

use App\Http\Controllers\Controller;
use App\Phuhuynh;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PhuhuynhController extends Controller
{
    //
    public function register(Request $request)
    {
        //VALIDATION HERE

        $student = Phuhuynh::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        //REGISTER NEW USER BY RECORDING NAME, PHONE
        return response()->json([
            'status_code'=>200,
            'message'=>'Parent registered successfully.',
            'data'=>[

            ]
        ]);
    }

    public function login(Request $request)
    {
        //VALIDATE PHONE NUMBER

        $parent = Phuhuynh::where('email',$request->email)->first();

        if(!$parent){
            return response()->json([
                'status_code'=>404  ,
                'message'=>'Student does not exist.',
                'data'=>[

                ]
            ]);
        }

        if(!Hash::check($request->password,$parent->password)){
            return response()->json([
                'status_code'=>401  ,
                'message'=>'Incorrect password',
                'data'=>[

                ]
            ]);
        }

        $parent->OauthAcessToken()->where('name','phuhuynh')->delete();
        $access_token = $parent->createToken('phuhuynh',['phuhuynh'])->accessToken;
        //LOGIN

        //RETURN DATA WITH access_TOKEN
        return response()->json([
            'status_code'=>200 ,
            'message'=>'Parent has successfully logged in OTP.',
            'data'=>[
                'user'=>$parent,
                'access_token'=>$access_token,
                'role'=> 3
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->OauthAcessToken()->where('name','phuhuynh')->delete();

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
            'data'=>$user
        ]);
    }
}
