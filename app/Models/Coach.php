<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coach extends User
{
    use HasFactory, SoftDeletes;

    protected $table = 'coaches';

    protected $fillable = [
        'verified_at',
    ];

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }
}
