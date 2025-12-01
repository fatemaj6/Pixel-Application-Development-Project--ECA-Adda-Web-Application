<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EcaEnrollment;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = EcaEnrollment::with('user','eca')->orderBy('created_at','desc')->paginate(20);
        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function markDone(EcaEnrollment $enrollment)
    {
        $enrollment->status = 'done';
        $enrollment->save();

        return back()->with('success','Enrollment marked done.');
    }
}
