<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'No account found for this email. Please register first.']);
        }

        $otp = rand(100000, 999999);
        $user->otp_code = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        // send OTP email
        Mail::to($user->email)->send(new OtpMail($otp, $user->name, 'Login'));

        // redirect to OTP entry screen (we'll pass the email as query)
        return redirect()->route('login.otp', ['email' => $user->email])
                         ->with('status', 'OTP sent to your email.');
    }

    public function showOtpForm(Request $request)
    {
        $email = $request->query('email');
        return view('auth.login-otp', compact('email'));
    }
}
?>