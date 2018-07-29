<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    protected $fillable = [
        'about_us_body', 'subscribe_body'
    ];

    protected $hidden = [
        'id', 'created_at', 'updated_at'
    ];
}
