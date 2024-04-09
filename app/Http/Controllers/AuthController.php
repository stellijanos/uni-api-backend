<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register() {

        // print_r(request()->all());

        // {"firstname":"Janos","lastname":"Stelli","email":"janos@stellijanos.com","birthDate":"2024-04-10","password":"123","confirmPassword":"123"}


        
        // request()->validate([
        //     'firstname' => 'required|string|max:64',
        //     'lastname' => 'required|string|max:64',
        //     'email' => 'required|email|max:128',
        //     'birthDate' => 'required',
        //     'password' => 'required|string',
        //     'confirmPasssword' => 'required|string',
        // ]);



        if (request()->get('password') !== request()->get('confirmPassword')) {
            return response()->json(['response' => 'Passwords do not match!']);
        }

        $user = User::where('email', request()->get('email'))->first();
        if ($user !== null) {
            return response()->json(['response' => 'User already exists!']);
        }

        $user = new User();

        $user->firstname = filter_var(request()->get('firstname'), FILTER_SANITIZE_STRING);
        $user->lastname = filter_var(request()->get('lastname'), FILTER_SANITIZE_STRING);
        $user->email = filter_var(request()->get('email'), FILTER_SANITIZE_STRING);
        $user->birthDate = request()->get('birthDate');
        $user->password = Hash::make(request()->get('password'));
        $user->login_token = Str::random(64);

        $user->save();
        return response()->json(['response' => 'success']);

    }


    public function login() {

        $email = filter_var(request()->get('email'), FILTER_SANITIZE_EMAIL) ?? '';
        $password = filter_var(request()->get('password'), FILTER_SANITIZE_STRING) ?? '';

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['response' => 'User not found']);
        }
        if (!Hash::check($password, $user->password)) {
            return response()->json(['response' => 'Incorrect Password']);
        }

        $user->logged_in = "YES";
        $user->save();
        return response()->json([
            'response' => 'success',
            'login_token' => $user->login_token
        ], 200);
    }

    public function isloggedIn($token) {
        $user = User::where('login_token', $token)->first();

        if (!$user) {
            return response()->json([
                'is_logged_in' => "NO",
                'role' => "NO"
            ]);
        } 
        $role = ($user->email === env('ADMIN_EMAIL')) ? "ADMIN" : "STUDENT" ;
        return response()->json([
            'is_logged_in' => $user->logged_in,
            'role' => $role
        ]);
    }
}
