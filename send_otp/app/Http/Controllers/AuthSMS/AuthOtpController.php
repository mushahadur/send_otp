<?php

namespace App\Http\Controllers\AuthSMS;

use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthOtpController extends Controller
{
    //
    public function login(){
        return view('otp.auth.otp-login');
    }

    public function generate(Request $request){
        $request->validate([
            'mobile_no' => 'required|exists:users,mobile_no'
        ]);

        $userOtp = $this->generateOTP($request->mobile_no);
        $userOtp->sendSMS($request->mobile_no); //Send OTP
        $user_id = $userOtp->user_id;
        return redirect()->route('otp.verification',compact('user_id'))
        ->with('success', 'OTP has been sent on your Mobie Number');
    }

    public function generateOTP($mobile_no){
        $user = User::where('mobile_no', $mobile_no)->first();
        $userOtp = UserOtp::where('user_id', $user->id)->latest()->first();
        $now = now();

        if($userOtp && $now->isBefore($userOtp->expite_at)){
            return $userOtp;
        }

        return UserOtp::create([
            'user_id' => $user->id,
            'otp' => rand(12345678, 99999999),
            'expite_at' => $now->addMinutes(3),
        ]);
        // 1. Already available but not expired
        // 2. Already available but expired
        // 3. Not available any otp
    }

    public function verificaton($user_id){
        // dd($user_id);
        return view('otp.auth.otp-verification')->with([
            'user_id' => $user_id,
        ]);

    }

    public function loginWithOtp(Request $request){
        // dd($request->all());
        $check = $request->validate([
            'otp' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);
        $userOtp = UserOtp::where('user_id', $request->user_id)->where('otp', $request->otp)->first();
        $now = now();
        if(!$userOtp){
            return redrect()->back()->with('error', 'Your OTP is not correct');
        }
        else if($userOtp && $now->isAfter($userOtp->expite_at)){
            return redrect()->back()->with('error', 'Your OTP has been Expired !');
        }

        $user =  User::whereId($request->user_id)->first();
        if($user){
            $userOtp->update([
                'expite_at' =>now()
            ]);

            Auth::login($user);
            return redirect('/home');
        }

        return redrect()->route('otp.login')->with('error', 'Your OTP is not correct !');
    }
}
