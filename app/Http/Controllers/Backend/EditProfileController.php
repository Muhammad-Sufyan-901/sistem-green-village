<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class EditProfileController extends Controller
{
    public function index()
    {
        $user = User::where('user_id', auth()->user()->user_id)->first();
        if(!$user)
            abort(404);

        // Decode data
        $decBankAccount = json_decode($user->bank_account);

        return view('backend.edit_profile.index', compact('user', 'decBankAccount'));
    }

    public function update(Request $request)
    {
        // Arr data update
        $dataUpdate = [
            'name' => $request->fullname,
            'phone' => $request->phone_number,
            'address' => $request->address
        ];
        if(auth()->user()->roles == 'driver')
        {
            $dataUpdate['bank_account'] = json_encode([
                'bank_name' => $request->bank_name,
                'bank_card_holder' => $request->bank_card_holder,
                'bank_account_number' => $request->bank_account_number
            ]);
        }

        // Function to change user profile
        $filename = '';
        if(!empty($request->file('user_profile')))
        {
            $allowedfileExtension = ['jpg','jpeg','png'];
            $filepath = public_path('upload/user_profiles/');
            $file = $request->file('user_profile');
            $getFileExt = $file->getClientOriginalExtension();
            $filename = date('Ymd').'-'.time().'.'.$getFileExt;
            
            $check = in_array($getFileExt, $allowedfileExtension);
            if(!$check)
                return response()->json(['status' => 'error', 'message' => 'Oops something went wrong, file extensions are not supported'], 422);

            // Delete first exists file
            if($request->current_user_profile)
            {
                if (file_exists($filepath.$request->current_user_profile))
                    unlink($filepath.$request->current_user_profile);
            }

            // Move File
            move_uploaded_file($file->getPathName(), $filepath.$filename);
            $dataUpdate['avatar'] = $filename;
        }

        // Update Function
        $update = User::where('user_id', auth()->user()->user_id)->update($dataUpdate);
        if($update)
            return response()->json(['status' => 'success', 'message' => 'Success! data updated successfully', 'next' => Route('backend.dash.edit-profile.index')]);
        else
            return response()->json(['status' => 'error', 'message' => 'Oops! something went wrong, data not saved'], 422);
    }
}
