<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function child()
    {
        return $this->belongsTo('App\Models\Child', 'child_id', 'id');
    }

    public function getTimeAttribute($value)
    {
        $date = date('d/m/Y - H:i:s', $value);
        return $date;
    }
}
