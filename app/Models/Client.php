<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['state_id', 'city_id', 'name', 'cnpj', 'cpf', 'cep', 'address', 'number', 'complement', 'neighborhood'];
}
