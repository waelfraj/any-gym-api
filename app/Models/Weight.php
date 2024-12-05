<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Weight extends Model
{
    use HasFactory;

    protected $table = 'weight_history';

    protected $fillable = ['weight', 'member_id', 'updated_at', 'created_at'];


    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
