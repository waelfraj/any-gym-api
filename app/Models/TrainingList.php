<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TrainingList extends Model
{
    protected $fillable = ['title', 'description', 'difficulty', 'total_calories', 'image', 'coach_id'];

    public function coach(): BelongsTo
    {
        return $this->belongsTo(Coach::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class,'member_training_list')->withTimestamps();
    }

    public function exercises(): belongsToMany
    {
        return $this->belongsToMany(Exercise::class)
            ->withTimestamps();
    }
}
