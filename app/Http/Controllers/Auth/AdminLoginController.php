<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        // validate basic login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->where('role', 'admin')->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Invalid admin credentials.']);
        }

        // generate OTP and send
        $otp = rand(100000, 999999);
        $user->otp_code = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        Mail::to($user->email)->send(new OtpMail($otp, $user->name, 'Admin Login'));

        // store admin id in session to verify OTP next
        session(['admin_pending_id' => $user->id]);

        return redirect()->route('admin.login.otp')->with('status', 'OTP sent to admin email.');
    }

    public function showOtpForm()
    {
        return view('auth.admin-login-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string'
        ]);

        $adminId = session('admin_pending_id');

        if (! $adminId) {
            return redirect()->route('admin.login')->withErrors(['email' => 'Please login with password first.']);
        }

        $user = User::find($adminId);

        if (! $user) {
            return redirect()->route('admin.login')->withErrors(['email' => 'Admin not found.']);
        }

        if (!$user->otp_code || !$user->otp_expires_at || Carbon::now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'OTP expired.']);
        }

        if ($user->otp_code !== $request->otp) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        // clear otp and session
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        session()->forget('admin_pending_id');

        // login the admin
        Auth::login($user);

        // redirect admin dashboard (create later)
        return redirect('/admin')->with('success', 'Admin logged in.');
    }
}
?>