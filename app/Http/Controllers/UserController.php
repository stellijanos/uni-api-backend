<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getStudents() {
        return response()->json(User::where('id', '<>', 1)->get());
    }

    public function deleteStudent($id) {
        $student = User::findOrFail($id);
        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }
        $student->delete();
        return response()->json(['message' => 'Student deleted successfully'], 200);
    }

    public function getProfile($token) {
        $user = User::where('login_token', $token)->first();

        if (!$user) {
            return response()->json([
                'response' => 'User not found!'
            ]);
        }

        return response()->json([
            'response' => 'success',
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'birthDate' => $user->birthDate
        ]);
    }

    public function saveProfile($token) {
        $user = User::where('login_token', $token)->first();

        if (!$user) {
            return response()->json([
                'response' => 'User not found!'
            ]);
        }
        if (!Hash::check(request()->get('password'), $user->password)) {
            return response()->json([
                'response' => 'Incorrect password'
            ]);
        }

        $user->firstname = filter_var(request()->get('firstname'), FILTER_SANITIZE_STRING);
        $user->lastname = filter_var(request()->get('lastname'), FILTER_SANITIZE_STRING);
        $user->email = filter_var(request()->get('email'), FILTER_SANITIZE_STRING);
        $user->birthDate = request()->get('birthDate');
        $user->save();

        return response()->json([
            'response' => "success"
        ]);
    }

}
