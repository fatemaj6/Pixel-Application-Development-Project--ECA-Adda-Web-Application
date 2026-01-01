<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RegisterController extends Controller
{
    // Step 1 - personal info
    public function step1()
    {
        return view('auth.register-step1');
    }

    public function storeStep1(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:30',
            'institution' => 'nullable|string|max:255',
            'education_level' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // keep in session for next steps
        $request->session()->put('register.data', $data);

        return redirect()->route('register.step2');
    }

    // Step 2 - choose tier
    public function step2(Request $request)
    {
        if (!$request->session()->has('register.data')) {
            return redirect()->route('register.step1');
        }
        return view('auth.register-step2');
    }

    public function storeStep2(Request $request)
    {
        $data = $request->validate([
            'package_type' => 'required|in:tier1,tier2',
        ]);

        $session = $request->session()->get('register.data', []);
        $session['package_type'] = $data['package_type'];
        $request->session()->put('register.data', $session);

        return redirect()->route('register.step3');
    }

    // Step 3 - payment placeholder / complete
    public function step3(Request $request)
    {
        if (!$request->session()->has('register.data')) {
            return redirect()->route('register.step1');
        }

        $data = $request->session()->get('register.data');

        if (!isset($data['package_type'])) {
            return redirect()->route('register.step2');
        }

        $amount = $data['package_type'] === 'tier1' ? 700 : 1000;

        return view('auth.register-step3', compact('data', 'amount'));
    }

public function complete(Request $request)
{
    if (!$request->session()->has('register.data')) {
        return redirect()->route('register.step1');
    }

    $data = $request->session()->get('register.data');

    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'] ?? null,
        'institution' => $data['institution'] ?? null,
        'education_level' => $data['education_level'],
        'package_type' => $data['package_type'],
        'payment_status' => 'pending',
        'registration_status' => 'pending',
        'password' => Hash::make($data['password']),
        'role' => 'user',
    ]);

    // ✅ login user BEFORE payment
    Auth::login($user);

    // clear session
    $request->session()->forget('register.data');

    // ✅ now auth middleware will pass
    return app(\App\Http\Controllers\PaymentController::class)->createSession();
}

}
?>


