<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleRegistrationController extends Controller
{
    public function create()
    {
        $grades = Grade::all(['id','name']);
        return view('auth.role-register', compact('grades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'grade' => 'required_if:role,STUDENT'
        ]);

        $user = User::find(auth()->user()->id);

        $data = $user->grades()->attach($request->grade);


        return redirect()->route('dashboard');
       
    }
}