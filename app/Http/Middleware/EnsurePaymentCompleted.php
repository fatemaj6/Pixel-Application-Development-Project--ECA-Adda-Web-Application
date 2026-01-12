<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsurePaymentCompleted
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->payment_status !== 'paid') {
            return redirect()->route('payment.checkout')
                ->with('status', 'Please complete payment to access the dashboard.');
        }

        if ($user->registration_status !== 'approved') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('status', 'Your registration is pending admin approval.');
        }

        return $next($request);
    }
}
?>
