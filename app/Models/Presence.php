<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function child()
    {
        return $this->belongsTo('App\Models\Child', 'child_id', 'id');
    }

    public function getCheckInAttribute($value) {
        if(date('H:i:s', $value) == '00:00:00') {
            $date = date('d/m', $value);
        }
        else {
            $date = date('d/m - H:i:s', $value);
        }
        return $date;
    }
}
