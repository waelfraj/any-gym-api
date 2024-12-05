<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'coach_id',
        'member_id',
        'title',
        'category',
        'number_participation',
        'room'
    ];

    public function coach(): BelongsTo
    {
        return $this->belongsTo(Coach::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class);
    }
}
