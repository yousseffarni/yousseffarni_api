<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Icon;

class Skill extends Model
{
    protected $table = 'skills';
    protected $fillable = [
        'name',
        'percentage',
        'icon_id',
    ];

    //protected $with = ['icon'];      
    //public function icon(){
    //    return $this->belongsTo(Icon::class, 'icon_id','id')->select('id','icon');
    //}

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];
}
