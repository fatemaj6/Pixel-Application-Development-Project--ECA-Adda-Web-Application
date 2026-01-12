<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Show the main dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Pass user to view for tier-aware rendering
        return view('dashboard.index', compact('user'));
    }

    /**
     * Profile Management - Personal Info.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('dashboard.profile', compact('user'));
    }

    /**
     * Update Profile with validation.
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric',
            'interests' => 'array|min:3',
        ]);

        $user = Auth::user();
        $user->update($request->only(['name', 'phone', 'institution', 'education_level', 'interests']));

        return redirect()->route('dashboard.profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Show enrolled ECAs.
     */
    public function myEcas()
    {
        $user = Auth::user();
        // Assuming relation: $user->ecas()
        $ecas = $user->ecas ?? [];
        return view('dashboard.ecas', compact('ecas'));
    }

    /**
     * Show subscription details.
     */
    public function subscription()
    {
        $user = Auth::user();
        return view('dashboard.profile.subscription', compact('user'));
    }

    /**
     * Security - Change password form.
     */
    public function security()
    {
        return view('dashboard.profile.security');
    }

    /**
     * Handle password update.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('dashboard.security')->with('success', 'Password updated successfully!');
    }

    /**
     * Tier 2 Exclusive - One-to-One Session booking.
     */
    public function session()
    {
        $user = Auth::user();

        if ($user->package_type !== 'tier2') {
            abort(403, 'Unauthorized access');
        }

        return view('dashboard.session', compact('user'));
    }
}

?>
