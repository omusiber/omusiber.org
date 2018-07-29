<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'activity_title', 'image_path', 'url', 'location', 'category', 'date', 'short_description', 'description'
    ];
    protected $hidden = [
        'id', 'created_at', 'updated_at'
    ];
}
