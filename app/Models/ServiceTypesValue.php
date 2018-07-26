<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ServiceTypesValue extends Model
{
    use SoftDeletes;

    protected $fillable = ['service_type_id', 'value'];
    protected $dates = ['deleted_at'];

    public function service_type()
    {
        return $this->belongsTo('App\Models\ServiceType');
    }

    //Get and Setors
    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d/m/Y H:i');
    }
}
