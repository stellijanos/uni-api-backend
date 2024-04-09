<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

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
}
