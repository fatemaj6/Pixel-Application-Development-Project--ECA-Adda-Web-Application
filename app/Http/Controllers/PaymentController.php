<?php
namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function checkout()
{
    $user = auth()->user();

    $amount = $user->package_type === 'tier1' ? 700 : 1000;

    return view('payment.checkout', compact('amount'));
}
public function createSession()
{
    $user = auth()->user();

    $amount = $user->package_type === 'tier1' ? 700 : 1000;

    Stripe::setApiKey(config('services.stripe.secret'));

    $session = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'bdt',
                'product_data' => [
                    'name' => strtoupper($user->package_type) . ' Subscription',
                ],
                'unit_amount' => $amount * 100,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',

        // 🔑 Pass user ID securely
        'metadata' => [
            'user_id' => $user->id,
        ],

        'success_url' => route('payment.success'),
        'cancel_url' => route('payment.cancel'),
    ]);

    // ✅ Save payment attempt
    Payment::create([
        'user_id' => $user->id,
        'stripe_session_id' => $session->id,
        'status' => 'pending',
        'amount' => $amount,
        'currency' => 'BDT',
        'package_type' => $user->package_type,
    ]);

    return redirect($session->url);
}

public function success(Request $request)
{
    $user = auth()->user();

    // Update latest pending payment
    $payment = Payment::where('user_id', $user->id)
        ->where('status', 'pending')
        ->latest()
        ->first();

    if ($payment) {
        $payment->update([
            'status' => 'paid',
        ]);
    }

    $user->update([
        'payment_status' => 'paid',
    ]);

    session()->forget('register.data');

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')
        ->with('success', 'Payment successful! Registration completed.');
}

public function cancel()
{
    return redirect()->route('payment.checkout')
        ->with('error', 'Payment was cancelled. Please try again.');
}

public function history()
{
    $payments = Payment::where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('dashboard.payments', compact('payments'));
}

}
?>
