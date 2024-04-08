<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register() {

        // print_r(request()->all());

        // {"firstname":"Janos","lastname":"Stelli","email":"janos@stellijanos.com","birthDate":"2024-04-10","password":"123","confirmPassword":"123"}


        request()->validate([
            'firstname' => 'required|string|max:64',
            'lastname' => 'required|string|max:64',
            'email' => 'required|email|max:128',
            'birthDate' => 'required',
            'password' => 'required|string',
            'confirmPasssword' => 'required|string',
        ]);

        if (request()->get('password') !== request()->get('confirmPassword')) {
            return response()->json(['response' => 'Passwords do not match!']);
        }

        $user = new User();

        $user->firstname = request()->get('firstname');
        $user->lastname = request()->get('lastname');
        $user->email = request()->get('email');
        $user->birthDate = request()->get('birthDate');
        $user->password = Hash::make(request()->get('password'));

        $user->save();
        return response()->json(['response' => 'User successfully registered!']);

    }
}

