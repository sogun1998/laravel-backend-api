<?php

namespace App\Http\Controllers\Authenticate;

use App\Student;
//use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentLoginController extends Controller
{
    public function register(Request $request)
    {
        //VALIDATION HERE

        $student = Student::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        //REGISTER NEW USER BY RECORDING NAME, PHONE
        return response()->json([
            'status_code'=>200,
            'message'=>'Student registered successfully.',
            'data'=>[

            ]
        ]);
    }

    public function login(Request $request)
    {
        //VALIDATE PHONE NUMBER

        $student = Student::where('email',$request->email)->first();

        if(!$student){
            return response()->json([
                'status_code'=>404  ,
                'message'=>'Student does not exist.',
                'data'=>[

                ]
            ]);
        }

        if(!Hash::check($request->password,$student->password)){
            return response()->json([
                'status_code'=>401  ,
                'message'=>'Incorrect password',
                'data'=>[

                ]
            ]);
        }

        $student->OauthAcessToken()->where('name','student')->delete();
        $access_token = $student->createToken('student',['student'])->accessToken;
        //LOGIN

        //RETURN DATA WITH access_TOKEN
        return response()->json([
            'status_code'=>200 ,
            'message'=>'Student has successfully logged in OTP.',
            'data'=>[
                'user'=>$student,
                'access_token'=>$access_token,
                'role'=> 2
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->OauthAcessToken()->where('name','student')->delete();

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
