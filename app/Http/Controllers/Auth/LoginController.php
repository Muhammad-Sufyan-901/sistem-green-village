<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $rules = [
            "email" => 'required|email',
            "password" => 'required'
        ];

        $this->validate($request, $rules);

        $remember_me = $request->has('remember_me') ? true : false;
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember_me))
        {
            // If user status not active
            if(auth()->user()->status != 'active')
            {
                auth()->logout();
                return response()->json(['status' => 'error', 'message' => 'Oops! something went wrong, your account is not active!'], 422);
            }

            $getRedirectUrl = Route('backend.dash.home');
            return response()->json(['status' => 'success', 'next' => $getRedirectUrl]);
        }
        else
            return response()->json(['status' => 'error', 'message' => 'Oops! something went wrong. Email/Password not matched'], 422);
    }
}
