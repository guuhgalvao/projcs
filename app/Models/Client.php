<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = ['state_id', 'city_id', 'name', 'cnpj', 'cpf', 'zipcode', 'address', 'number', 'complement', 'neighborhood'];
    protected $dates = ['deleted_at'];

    public function rules($submitType, Request $request = NULL){
        switch($submitType){
            case "add":
                return [
                    "name"          => "required|string|min:3|max:60|unique:clients",
                    "cnpj"          => "nullable|required_if:id_type,cnpj|string|size:18|unique:clients",
                    "cpf"           => "nullable|required_if:id_type,cpf|string|size:14|unique:clients",
                    "zipcode"       => "nullable|string|size:9",
                    "state_id"      => "nullable|integer|exists:states,id",
                    "city_id"       => "nullable|integer|exists:cities,id",
                    "address"       => "nullable|string",
                    "number"        => "nullable|integer",
                    "complement"    => "nullable|max:45",
                    "neighborhood"  => "nullable|string|max:60",
                ];
                break;              
            
            case "update":
                return [
                    "id"            => "required|integer|exists:clients",
                    "name"          => "required|string|min:3|max:60|unique:clients,name,".$request->id,
                    "cnpj"          => "required_if:id_type,cnpj|string|size:18|unique:clients,cnpj,".$request->id,
                    "cpf"           => "required_if:id_type,cpf|string|size:14|unique:clients,cpf,".$request->id,
                    "zipcode"       => "nullable|string|size:9",
                    "state_id"      => "nullable|integer|exists:states,id",
                    "city_id"       => "nullable|integer|exists:cities,id",
                    "address"       => "nullable|string",
                    "number"        => "nullable|integer",
                    "complement"    => "nullable|max:45",
                    "neighborhood"  => "nullable|string|max:60",
                ];
                break;
        }
    }

    public function messages(){
        return [
            "id.required"           => "Selecione um registro",
            "id.integer"            => "O registro selecionado é inválido",
            "id.exists"             => "O registro selecionado não existe",
            "name.required"         => "O campo nome é obrigatório",
            "name.string"           => "Este nome é inválido",
            "name.min"              => "O nome deve ter no mínimo 3 caracteres",
            "name.max"              => "O nome deve ter no maximo 60 caracteres",
            "name.unique"           => "Este nome já está em uso",
            "cnpj.required_if"  => "O campo CNPJ é obrigatório",
            "cnpj.string"           => "Este CNPJ é inválido",
            "cnpj.size"             => "O CNPJ deve ter 18 caracteres",
            "cnpj.unique"           => "Este CNPJ já está em uso",
            "cpf.required_if"   => "O campo CPF é obrigatório",
            "cpf.string"            => "Este CPF é inválido",
            "cpf.size"              => "O CPF deve ter 14 caracteres",
            "cpf.unique"            => "Este CPF já está em uso",
            "zipcode.string"        => "Este CEP é inválido",
            "zipcode.size"          => "O CEP deve ter 9 caracteres",
            "state_id.integer"      => "Este estado é inválido",
            "state_id.exists"       => "Este estado não existe",
            "city_id.integer"       => "Esta cidade é inválida",
            "city_id.exists"        => "Esta cidade não existe",
            "address.string"        => "Este endereço é inválido",
            "number.integer"        => "Este número é inválido",
            "number.max"            => "O campo número deve ter no maximo 5 caracteres",
            "complement.max"        => "O complement deve ter no maximo 45 caracteres",
            "neighborhood.string"   => "Este bairro é inválido",
            "neighborhood.max"      => "O bairro deve ter no maximo 60 caracteres",
        ];
    }
}
