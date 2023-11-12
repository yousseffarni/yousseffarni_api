<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    protected $fillable = [
        'type',
        'name',
        'image',
        'technologies',
        'link',
        'version',
        'date_creation',
        'date_modifcation'
    ];

}
