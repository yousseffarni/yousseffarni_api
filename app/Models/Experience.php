<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $table = 'experience';
    protected $fillable = [
        'company',
        'image',
        'type',
        'date_start',
        'date_end',
        'details',
        'technologies',
    ];

}
