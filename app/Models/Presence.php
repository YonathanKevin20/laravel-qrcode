<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function getCheckInAttribute($value) {
        return date('H:i:s', $value);
    }
}
