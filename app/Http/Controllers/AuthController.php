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
                'name.required' => 'სახელის ველი სავალდებულოა',
                'email.required' => 'ელ ფოსტა სავალდებულოა',
                'email.email' => 'გთხოვთ შეიყვანთ სწორი ელ-ფოსტის მისამართი',
                'email.unique' => 'ეს ელ-ფოსტა უკვე რეგისტრირებულია',
                'password.required' => 'პაროლის ველი სავალდებულოა',
                'password.min' => 'პაროლი უნდა შეიცავდეს მინიმუმ 8 სიმბოლოს',
                'password.confirmed' => 'პაროლი არ ემთხვევა',
            ]);
    
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            $token = $user->createToken('auth_token')->plainTextToken;

            Mail::to($user->email)->send(new WelcomeMail($user));
    
            return response()->json([
                'message' => 'წარმატებით გაიარეთ რეგისტრაცია',
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
        try{
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ], [
                'email.required' => 'ელ-ფოსტის ველი სავალდებულოა.',
                'email.string' => 'ელ-ფოსტის ველი უნდა შეიცავდეს ტექსტს.',
                'email.email' => 'გთხოვთ, შეიყვანეთ სწორი ელ-ფოსტის მისამართი.',
                'password.required' => 'პაროლის ველი სავალდებულოა.',
                'password.string' => 'პაროლის ველი უნდა შეიცავდეს ტექსტს.',
            ]);
    
            $user = User::where('email', $request->email)->first();
    
            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['შეყვანილი მონაცემები არასწორია'],
                ]);
            }
    
            $user->tokens()->where('name', 'auth_token')->delete();
    
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json([
                'message' => 'წარმატებით გაიარეთ ავტორიზაცია',
                'token' => $token,
            ]);
        }catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ],500);
        }

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