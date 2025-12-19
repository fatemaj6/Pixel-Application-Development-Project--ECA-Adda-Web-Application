<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\RegistrationApproved;
use App\Mail\RegistrationCorrectionRequested;
use App\Mail\RegistrationRejected;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    public function index()
    {
        $users = User::where('registration_status','pending')->orderBy('created_at','desc')->paginate(12);
        return view('admin.registrations.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.registrations.show', compact('user'));
    }

    public function approve(User $user)
    {
        $user->registration_status = 'approved';
        $user->payment_status = $user->payment_status ?: 'paid'; // adjust as needed
        $user->save();

        Mail::to($user->email)->send(new RegistrationApproved($user));

        return redirect()->route('admin.registrations.index')->with('success','User approved and notified.');
    }

    public function requestCorrection(Request $request, User $user)
    {
        $request->validate(['notes' => 'required|string|max:2000']);

        $user->registration_status = 'correction_requested';
        $user->save();

        Mail::to($user->email)->send(new RegistrationCorrectionRequested($user, $request->notes));

        return back()->with('success','Correction request sent.');
    }

    public function reject(Request $request, User $user)
    {
        $request->validate(['notes' => 'nullable|string|max:2000']);

        $user->registration_status = 'rejected';
        $user->save();

        Mail::to($user->email)->send(new RegistrationRejected($user, $request->notes));

        return redirect()->route('admin.registrations.index')->with('success','User rejected and notified.');
    }
}