<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['datetime'];
    public $timestamps = false;

    public function child()
    {
        return $this->belongsTo('App\Models\Child', 'child_id', 'id');
    }

    public function getDatetimeAttribute()
    {
        if(date('H:i:s', $this->check_in) == '00:00:00') {
            $date = date('d/m', $this->check_in);
        }
        else {
            $date = date('d/m - H:i:s', $this->check_in);
        }
        return $date;
    }
}
