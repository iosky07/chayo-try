<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index ()
    {
        return view('pages.user.index', [
            'user' => User::class
        ]);
    }

    public function show(Request $request)
    {
        return view('profile.show', [
            'request' => $request,
            'user' => $request->user(),
        ]);
    }
}
