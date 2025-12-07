<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shortcut extends Model
{
      protected $fillable = [
        'title', 'option', 'image', 'link', 'status',
    ];
}
