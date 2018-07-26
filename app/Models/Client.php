<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = ['state_id', 'city_id', 'name', 'cnpj', 'cpf', 'zipcode', 'address', 'number', 'complement', 'neighborhood'];
    protected $dates = ['deleted_at'];
}
