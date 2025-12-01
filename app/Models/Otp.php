<?php

// app/Models/Otp.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Otp extends Model
{
    protected $fillable = ['phone','code_hash','purpose','attempts','expires_at'];
    protected $dates = ['expires_at'];

    public function isExpired(): bool {
        return $this->expires_at instanceof Carbon ? $this->expires_at->isPast() : now()->isAfter($this->expires_at);
    }
}