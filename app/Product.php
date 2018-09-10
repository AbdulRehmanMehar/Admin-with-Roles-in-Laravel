<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Product extends Model
{
    protected $fillable=[
        'name','price','image','description'
    ];
}
