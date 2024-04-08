<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getStudents() {
        return response()->json(User::where('id', '<>', 1)->get());
    }
}
