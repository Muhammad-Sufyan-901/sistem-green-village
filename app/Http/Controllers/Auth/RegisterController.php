<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use Auth;
use Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Store Function
        $store = User::create([
            'roles' => 'driver',
            'name' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => 'inactive'
        ]);
        if($store)
            return response()->json(['status' => 'success', 'message' => 'Success!, your account already registered. Please waiting until admin approved your account!']);
        else
            return response()->json(['status' => 'error', 'message' => 'Oops! something went wrong. Data was not saved'], 422);
    }
}
