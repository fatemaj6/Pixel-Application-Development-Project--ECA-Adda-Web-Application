<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'stripe_session_id',
        'stripe_payment_intent',
        'status',
        'amount',
        'currency',
        'package_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
?>