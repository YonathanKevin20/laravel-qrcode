<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function getCheckInAttribute($value) {
        if(substr($value, 8) == '00') {
            $date = date('d/m', $value);
        }
        else {
            $date = date('d/m - H:i:s', $value);
        }
        return $date;
    }
}
