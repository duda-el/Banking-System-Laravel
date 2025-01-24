<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    public function register(Request $request){

        try{
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users', 
                'password' => 'required|string|min:8|confirmed',
            ], [
                'name.required' => 'saxelis veli savaldebuloa.',
                'email.required' => 'el-postis veli savaldebuloa.',
                'email.email' => 'gtxovt sheiyvanet swori el-postis misamarti.',
                'email.unique' => 'es el-posta ukve registrirebulia.',
                'password.required' => 'parolis veli savaldebuloa.',
                'password.min' => 'paroli unda sheicavdes minimum 8 simbolos.',
                'password.confirmed' => 'paroli ar emtxveva.',
            ]);
    
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            $token = $user->createToken('auth_token')->plainTextToken;

            Mail::to($user->email)->send(new WelcomeMail($user));
    
            return response()->json([
                'message' => 'User registered successfully',
                'token' => $token,
            ],201);

        } catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ],500);
        }
        
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user->tokens()->where('name', 'auth_token')->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
        ]);

    }


    public function logout(Request $request){
        if (!$request->user()) {
            return response()->json([
                'message' => 'User is not logged in.'
            ], 400); 
        }

        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully.'
        ], 200);
    }

}