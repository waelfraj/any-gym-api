<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertisementImage extends Model
{
    use HasFactory;

    protected $table = 'advertisement_images';
    protected $fillable = [
        'name',
        'image',
        'description',

    ];


}
