<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EcaEnrollment;

class EnrollmentController extends Controller
{
    public function index()
{
    $enrollments = EcaEnrollment::with(['user','eca'])
        ->where('status', 'pending')
        ->get();

    return view('admin.enrollments.index', compact('enrollments'));
}

public function markDone(EcaEnrollment $enrollment)
{
    $enrollment->update(['status' => 'approved']);

    return back()->with('success', 'Enrollment approved.');
}
}
