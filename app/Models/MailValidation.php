<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailValidation extends Model
{
    use HasFactory;

    public $table ='mail_validation_tokens';
    public $timestamps = false;

    protected $fillable =[
        'email',
        'token',
        'created_at'
    ];
}
