<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Member extends User
{
    use HasFactory;

    protected $table = 'members';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'objective_id',
        'height',
        'target_weight',
        'food_preference'
    ];

    public function imc(): HasMany
    {
        return $this->hasMany(Imc::class);
    }

    public function weight(): HasMany
    {
        return $this->hasMany(Weight::class);
    }

    public function objective(): BelongsTo
    {
        return $this->belongsTo(Objective::class);
    }

    public function training_lists(): belongsToMany
    {
        return $this->belongsToMany(TrainingList::class, 'member_training_list')->withTimestamps();
    }

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function appointments(): BelongsToMany
    {
        return $this->belongsToMany(Appointment::class);
    }

}
