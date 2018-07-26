<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class PaymentMethod extends Model
{
    use SoftDeletes;

    protected $fillable = ['code', 'name', 'card'];
    protected $dates = ['deleted_at'];

    public function rules($submitType, Request $request = NULL){
        switch($submitType){
            case "add":
                return [
                    "code"  => "required|integer|min:1|unique:payment_methods",
                    "name"  => "required|min:3|max:60|unique:payment_methods",
                ];
                break;              
            
            case "update":
                return [
                    "id"    => "required|integer|exists:payment_methods",
                    "code"  => "required|integer|min:1|unique:payment_methods,code,".$request->id,
                    "name"  => "required|min:3|max:60|unique:payment_methods,name,".$request->id,
                ];
                break;
        }
    }

    public function messages(){
        return [
            "id.required"       => "Selecione um registro",
            "id.integer"        => "O registro selecionado é inválido",
            "id.exists"         => "O registro selecionado não existe",
            "code.required"     => "O campo código é obrigatório",
            "code.integer"      => "Este código é inválido",
            "code.min"          => "O código deve ter no mínimo 1 caracteres",
            "code.unique"       => "Este código já está em uso",
            "name.required"     => "O campo nome é obrigatório",
            "name.min"          => "O nome deve ter no mínimo 3 caracteres",
            "name.max"          => "O nome deve ter no maximo 60 caracteres",
            "name.unique"       => "Este nome já está em uso",
        ];
    }
}
