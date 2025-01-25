<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use Image;
use Hash;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::where(function($query) use ($request) {
            // Filter
                if($request->filter == 'true')
                {
                    $query->where('roles', 'LIKE', '%'.strtolower($request->keyword).'%');
                    $query->orWhere('name', 'LIKE', '%'.$request->keyword.'%');
                    $query->orWhere('email', 'LIKE', '%'.$request->keyword.'%');
                    $query->orWhere('phone', 'LIKE', '%'.$request->keyword.'%');
                    $query->orWhere('status', 'LIKE', '%'.strtolower($request->keyword).'%');
                }

            $query->whereIn('roles', ['driver']);
        })
        ->orderBy('created_at', 'DESC')
        ->paginate(10)
        ->appends(request()->query());

        return view('backend.drivers.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.drivers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Function to upload user profile
        $allowedfileExtension = ['jpg','jpeg','png'];
        $filepath = public_path('upload/user_profiles/');
        $file = $request->file('user_profile');
        $filename = '';
        if(!empty($request->file('user_profile')))
        {
            $getFileExt = $file->getClientOriginalExtension();
            $filename = date('Ymd').'-'.time().'.'.$getFileExt;
            
            $check = in_array($getFileExt, $allowedfileExtension);
            if(!$check)
                return response()->json(['status' => 'error', 'message' => 'Oops something went wrong, file extensions are not supported'], 422);

            // Move File
            move_uploaded_file($file->getPathName(), $filepath.$filename);
        }

        // Store Function
        $store = User::create([
            'roles' => 'driver',
            'name' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone_number,
            'address' => $request->address,
            'avatar' => $filename,
            'status' => $request->status,
            'bank_account' => json_encode([
                'bank_name' => $request->bank_name,
                'bank_card_holder' => $request->bank_card_holder,
                'bank_account_number' => $request->bank_account_number
            ])
        ]);
        if($store)
            return response()->json(['status' => 'success', 'message' => 'Success! data created successfully', 'next' => Route('backend.drivers.index')]);
        else
            return response()->json(['status' => 'error', 'message' => 'Oops! something went wrong, data not saved'], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where('user_id', $id)->first();
        if(!$user)
            abort(404);

        // Decode data
        $decBankAccount = json_decode($user->bank_account);

        return view('backend.drivers.detail', compact('user', 'decBankAccount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::where('user_id', $id)->first();
        if(!$user)
            abort(404);

        // Decode data
        $decBankAccount = json_decode($user->bank_account);

        return view('backend.drivers.edit', compact('user', 'decBankAccount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Arr data update
        $dataUpdate = [
            'name' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone_number,
            'address' => $request->address,
            'status' => $request->status,
            'bank_account' => json_encode([
                'bank_name' => $request->bank_name,
                'bank_card_holder' => $request->bank_card_holder,
                'bank_account_number' => $request->bank_account_number
            ])
        ];

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
        $update = User::where('user_id', $id)->update($dataUpdate);
        if($update)
            return response()->json(['status' => 'success', 'message' => 'Success! data updated successfully', 'next' => Route('backend.drivers.index')]);
        else
            return response()->json(['status' => 'error', 'message' => 'Oops! something went wrong, data not saved'], 422);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('user_id', $id)->first();
        if(!$user)
            abort(404);

        // Delete first exists file
        $filepath = public_path('upload/user_profiles/');
        if($user->avatar)
        {
            if (file_exists($filepath.$user->avatar))
                unlink($filepath.$user->avatar);
        }

        // Delete Function
        User::where('user_id', $id)->delete();
        return redirect()->back();
    }
}
