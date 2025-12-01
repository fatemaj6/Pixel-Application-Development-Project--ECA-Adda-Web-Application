<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcaEnrollment extends Model
{
    use HasFactory;

    protected $fillable = ['eca_id','user_id','status','note'];

    public function eca()
    {
        return $this->belongsTo(Eca::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
