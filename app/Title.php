<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $fillable = [
        'about_us', 'projects', 'activities', 'gallery', 'members', 'contact'
    ];

    protected $hidden = [
        'id', 'created_at', 'updated_at'
    ];
}
