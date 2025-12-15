<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'institution',
        'education_level',
        'package_type',
        'role',
        'payment_status',
        'otp_code',
        'otp_expires_at',
        'interests', // ✅ allow mass assignment of interests
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp_code',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at'    => 'datetime',
        'interests'         => 'array', // ✅ automatically cast JSON to array
    ];

    public function ecaEnrollments()
{
    return $this->hasMany(\App\Models\EcaEnrollment::class);
}

}
