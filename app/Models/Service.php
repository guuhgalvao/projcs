<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'client_id', 'service_type_id', 'vehicle_id', 'order', 'value', 'status', 'annotations', 'started_in'];
    protected $dates = ['deleted_at'];

    //Relationship
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function vehicle()
    {
        return $this->belongsTo('App\Models\Vehicle');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }
    
    public function service_type()
    {
        return $this->belongsTo('App\Models\ServiceType');
    }

    //Getors and Setors
    public function setStartedInAttribute($value)
    {
        $this->attributes['started_in'] = Carbon::createFromFormat('d/m/Y H:i:s', $value)->format('Y-m-d H:i:s');
    }

    public function getStartedInAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d/m/Y H:i');
    }

    public function setFinishedInAttribute($value)
    {
        $this->attributes['finished_in'] = Carbon::createFromFormat('d/m/Y H:i:s', $value)->format('Y-m-d H:i:s');
    }

    public function getFinishedInAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d/m/Y H:i');
    }
}
