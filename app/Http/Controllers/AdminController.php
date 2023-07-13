<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $studentCount = User::where('role', 'STUDENT')->count();
        $teacherCount = User::where('role', 'TEACHER')->count();
        $adminCount = User::where('is_admin', 1)->count();

        return view('admin.index', compact('studentCount', 'teacherCount', 'adminCount'));
    }
}