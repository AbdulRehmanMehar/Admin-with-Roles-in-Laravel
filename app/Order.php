<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'cart','user_id','state','staff_id',
    ];
}
