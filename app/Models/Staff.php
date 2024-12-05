<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Staff extends User
{
    use HasFactory;

    protected $table = 'staffs';

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }
}
