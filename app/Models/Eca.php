<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eca extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'thumbnail',
        'instructor',
        'short_description',
        'full_description',
        'level',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'eca_user');
    }
      public function enrollments()
    {
        return $this->hasMany(EcaEnrollment::class);
    }
}
?>