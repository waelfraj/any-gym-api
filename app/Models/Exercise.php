<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exercise extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title', 'description', 'image', 'difficulty', 'category', 'calories', 'sets'
    ];

    public function training_lists(): belongsToMany
    {
        return $this->belongsToMany(TrainingList::class)
            ->withTimestamps();
    }

}
