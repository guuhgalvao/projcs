<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes;

    protected $fillable = ['plate', 'brand', 'model', 'color'];
    protected $dates = ['deleted_at'];
}
