<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use Hash;
use Auth;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('backend.change_password.index');
    }

    public function update(Request $request)
    {
        // Match the current password
        if(!Hash::check($request->current_password, auth()->user()->password)){
            return response()->json(['status' => 'error', 'message' => 'Oops! something went wrong, current password not matched'], 422);
        }

        // Update data user
        $updateDataUser = User::where('user_id', Auth::user()->user_id)->update([
            'password' => Hash::make($request->password)
        ]);
        if(!$updateDataUser)
            return response()->json(['status' => 'error', 'message' => 'Oops! something went wrong, password not updated'], 422);

        return response()->json(['status' => 'success', 'message' => 'Success! data updated successfully', 'next' => Route('backend.dash.change-password.index')]);
    }
}
