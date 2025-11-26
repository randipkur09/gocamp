<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class OtpController extends Controller
{
    // ➤ VIEW: Forgot Password
    public function forgotPasswordView()
    {
        return view('auth.forgot-password');
    }

    // ➤ SEND OTP
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'Email tidak terdaftar!');
        }

        $otp = rand(100000, 999999);

        PasswordOtp::where('email', $request->email)->delete();

        PasswordOtp::create([
            'email' => $request->email,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);

        Mail::raw("Kode OTP reset password kamu: $otp", function ($message) use ($request) {
            $message->to($request->email)->subject('OTP Reset Password GoCamp');
        });

        return redirect()->route('otp.view')->with('email', $request->email);
    }

    // ➤ VIEW: Input OTP
    public function verifyOtpView()
    {
        return view('auth.verify-otp');
    }

    // ➤ VERIFY OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required'
        ]);

        $check = PasswordOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$check) return back()->with('error', 'OTP salah!');

        if (Carbon::now()->greaterThan($check->expires_at)) {
            return back()->with('error', 'OTP sudah kadaluarsa!');
        }

        // Berhasil
        return redirect()->route('reset.view')->with('email', $request->email);
    }

    // ➤ VIEW: Reset Password
    public function resetPasswordView()
    {
        return view('auth.reset-password');
    }

    // ➤ RESET PASSWORD
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        PasswordOtp::where('email', $request->email)->delete();

        return redirect('/login')->with('success', 'Password berhasil direset!');
    }
}
