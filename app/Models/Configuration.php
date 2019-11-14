<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public static function getValue($parameter)
    {
        $res = static::where('parameter', $parameter)->first();
        $type = $res->type;
        if($type == 'string') return $res->value;
        elseif($type == 'integer') return intval($res->value);
    }
}
