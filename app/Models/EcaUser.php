<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcaUser extends Model
{
    use HasFactory;

    protected $table = 'eca_user';

    protected $fillable = [
        'user_id',
        'eca_id'
    ];
}
?>