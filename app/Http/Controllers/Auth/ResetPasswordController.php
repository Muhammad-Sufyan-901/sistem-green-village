<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use DB;

class ResetPasswordController extends Controller
{
    public function index(Request $request, $token)
    {
        $getData = DB::table('password_reset_tokens')->where('token', $token)->first();
        if(!$getData) abort(419);

        // 
        return view('auth.reset_password', compact('token'));
    }

    public function store(Request $request, $token)
    {
        $getData = DB::table('password_reset_tokens')->where('token', $token)->first();
        if(!$getData) return response()->json(['status' => 'error', 'message' => 'Oops! something went wrong. Token invalid/expired'], 422);

        // Update data user
        $updateUser = User::where('email', $getData->email)->update([
            'password' => bcrypt($request->input('password'))
        ]);
        if(!$updateUser)
            return response()->json(['status' => 'error', 'message' => "Oops, New password doesn't received"], 422);
        else
        {
            // Destroy older token
            DB::table('password_reset_tokens')->where('email', $getData->email)->first();

            // 
            return response()->json(['status' => 'success', 'next' => Route('auth.login')]);
        }
    }
}
