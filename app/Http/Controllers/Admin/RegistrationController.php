<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\RegistrationApproved;
use App\Mail\RegistrationCorrectionRequested;
use App\Mail\RegistrationRejected;
use Illuminate\Support\Facades\Mail;
use App\Models\RefundLog;
use Illuminate\Support\Facades\DB;

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

        //Mail::to($user->email)->send(new RegistrationApproved($user));

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

        DB::beginTransaction();
        try {
            $user->registration_status = 'rejected';
            $user->save();

            // attempt refund via RefundService (stub)
            $refundLog = RefundLog::create([
                'user_id' => $user->id,
                'payment_reference' => $user->id . '-' . now()->timestamp,
                'provider_response' => null,
                'status' => 'initiated',
                'notes' => 'Auto refund initiated by admin'
            ]);

            // call refund service (stub) - replace with real provider code
            $refundResult = $this->processRefundStub($user, $refundLog);

            $refundLog->provider_response = $refundResult['response'] ?? null;
            $refundLog->status = $refundResult['status'] ?? 'failed';
            $refundLog->save();

            Mail::to($user->email)->send(new RegistrationRejected($user, $refundResult));

            DB::commit();

            return redirect()->route('admin.registrations.index')->with('success','User rejected, refund initiated and user notified.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to reject: '.$e->getMessage()]);
        }
    }

    // --- stub refund method, replace with Stripe/Brevo/etc integration ---
    protected function processRefundStub(User $user, RefundLog $log)
    {
        // Placeholder: call Stripe refund API here. Return structured array.
        // Example successful structure:
        return [
            'status' => 'success',
            'response' => 'REFUND_STUB_OK',
            'notes' => 'This is a stubbed refund. Replace with Stripe SDK.'
        ];
    }
}
