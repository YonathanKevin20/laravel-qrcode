<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Child extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['age'];

    public function getAgeAttribute()
    {
    	return Carbon::parse($this->date_of_birth)->age;
    }
}
