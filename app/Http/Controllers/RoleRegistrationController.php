<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleRegistrationController extends Controller
{
    public function create()
    {
        return view('auth.role-register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'grade' => 'required_if:role,STUDENT'
        ]);

        $user = User::find(auth()->user()->id);

        $data = $user->update([
            'role' => $request->role
        ]);


        return redirect()->route('dashboard');
       
    }
}