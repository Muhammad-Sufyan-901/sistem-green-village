<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use App\Mail\ForgotPasswordMail;

use DB;
use Mail;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('auth.forgot_password');
    }

    public function store(Request $request)
    {
        // Validate first if email not registered
        $userExists = User::where('email', $request->email)->count();
        if($userExists == 0) 
            return redirect()->back()->with('error-messages', [
                'err' => [
                    'status' => 'Error',
                    'msg' => 'Oops, User has not been registered'
                ],
            ]);

        // Update or Create request
        $token = $this->uuidv4();
        DB::table('password_reset_tokens')->updateOrInsert(['email' => $request->email], [
            'token' => $token, 
            'created_at' => NOW()
        ]);
        
        // Send mail function
        $mailData = [
            'user_email' => $request->email,
            '_token' => $token,
            'reset_link' => Route('auth.reset-password', $token)
        ];
        Mail::to($mailData['user_email'])->send(new ForgotPasswordMail($mailData));

        // Return
        return response()->json(['status' => 'success', 'message' => 'Success!, Forgot password request already sent, please check your email to getting password reset link.']);
    }

    // Custom UUIDv4
    public function uuidv4()
    {
        $data = random_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
            
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
