<?php
namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $data = session('register.data');

        if (!$data) {
            return redirect()->route('register.step1');
        }

        $amount = $data['package_type'] === 'tier1' ? 700 : 1000;

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency' => 'bdt',
                    'product_data' => [
                        'name' => strtoupper($data['package_type']) . ' Subscription',
                    ],
                    'unit_amount' => $amount * 100,
                ],
                'quantity' => 1,
            ]],
            'success_url' => route('payment.success'),
            'cancel_url' => route('payment.cancel'),
        ]);

        Payment::create([
            'stripe_session_id' => $session->id,
            'amount' => $amount,
            'package_type' => $data['package_type'],
            'status' => 'pending',
        ]);

        return redirect($session->url);
    }

    public function success()
    {
        return view('payment.success');
    }

    public function cancel()
    {
        return view('payment.cancel');
    }
}
?>