<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class UserController extends Controller
{

    public function get_login()
    {
        return view('back.login');
    }

    public function post_login(Request $request)
    {
        $request->validate([
            'email' => 'required|max:255|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route(RouteServiceProvider::HOME);
        } else {

            return redirect()->back();
        }
    }
}
