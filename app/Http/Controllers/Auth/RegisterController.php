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

        return redirect()->to(route('register.step2', [], false));
    }

    // Step 2 - choose tier
    public function step2(Request $request)
    {
        if (!$request->session()->has('register.data')) {
            return redirect()->to(route('register.step1', [], false));
        }
        return view('auth.register-step2');
    }

    public function storeStep2(Request $request)
    {
        if (!$request->session()->has('register.data')) {
            return redirect()->to(route('register.step1', [], false));
        }

        $data = $request->validate([
            'package_type' => 'required|in:tier1,tier2',
        ]);

        $session = $request->session()->get('register.data', []);
        $session['package_type'] = $data['package_type'];
        $request->session()->put('register.data', $session);

        return $this->startPayment($request, $session);
    }

    // Step 3 - payment placeholder / complete
    public function step3(Request $request)
    {
        if (!$request->session()->has('register.data')) {
            return redirect()->to(route('register.step1', [], false));
        }
        return redirect()->to(route('register.step2', [], false));
    }

    public function complete(Request $request)
    {
        if (!$request->session()->has('register.data')) {
            return redirect()->to(route('register.step1', [], false));
        }

        $data = $request->session()->get('register.data');

        return $this->startPayment($request, $data);
    }

    private function startPayment(Request $request, array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if (! $user) {
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
        } else {
            $user->package_type = $data['package_type'] ?? $user->package_type;
            $user->save();
        }

        Auth::login($user);

        $request->session()->forget('register.data');

        return app(\App\Http\Controllers\PaymentController::class)->createSession();
    }

}
?>
