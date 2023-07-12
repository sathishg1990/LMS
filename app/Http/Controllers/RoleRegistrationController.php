<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleRegistrationController extends Controller
{
    public function create()
    {
        return view('auth.role-register');
    }

    public function store(Request $request)
    {
        //return view('auth.role-register');
    }
}