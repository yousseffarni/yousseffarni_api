<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $table = 'certifications';
    protected $fillable = [
        'date_start',
        'date_end',
        'image',
        'specialization',
        'institute',
        'description',
        'link',
    ];

}
