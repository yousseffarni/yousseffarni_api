<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileInfo extends Model
{
    protected $table = 'profile_info';
    protected $fillable = [
        'type',
        'title',
        'value',
        'icon',
    ];

}
