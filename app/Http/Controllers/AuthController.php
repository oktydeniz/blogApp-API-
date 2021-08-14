<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerAction(Request $request){
        $fields = $request->validate([
            'email'=>'required|string|unique:users,email',
            'password'=>'required|string|confirmed'
        ]);

        $user = User::create([
            'email'=>$fields['email'],
            'password'=>bcrypt($fields['password'])
        ]);

        $token = $user->createToken('apptoken')->plainTextToken;

        $response = [
            'user'=>$user,
             'token'=>$token
        ];

        return response($response,201);

    }
    
    public function logoutAction(){
        auth()->user()->tokens()->delete();
        return response([
            'message' =>'logged out'
        ],201);
    }
    public function loginAction(Request $request){
        $fields = $request->validate([
            'email'=>'required|string',
            'password'=>'required|string'
        ]);

        // email 
        $user =User::where('email',$fields['email'])->first();

        // password 
        if(!$user  || !Hash::check($fields['password'],$user->password) ){
            return response([
                'message'=>'Bad creds',
                
            ],401);
        }

        $token = $user->createToken('apptoken')->plainTextToken;

        $response = [
            'user'=>$user,
            'token'=>$token
        ];

        return response($response,201);
    }
}
