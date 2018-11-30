<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehiclesObservation extends Model
{
    use SoftDeletes;

    protected $fillable = ['vehicle_id', 'observation'];
    protected $dates = ['deleted_at'];

    //Validation
    public function rules($submitType, Request $request = NULL){
        switch($submitType){
            case "add":
                return [
                    "vehicle_id"    => "required|integer|exists:vehicles,id",
                    "observation"   => "required|string",
                ];
                break;              
            
            case "update":
                return [
                    "id"            => "required|integer|exists:vehicles_observations",
                    "vehicle_id"    => "required|integer|exists:vehicles,id",
                    "observation"   => "required|string",
                ];
                break;
        }
    }

    public function messages(){
        return [
            "id.required"           => "Selecione um registro",
            "id.integer"            => "O registro selecionado é inválido",
            "id.exists"             => "O registro selecionado não existe",
            "vehicle_id.required"   => "O combo veículo é obrigatório",
            "vehicle_id.integer"    => "Este veículo é inválido",
            "vehicle_id.exists"     => "Este veículo não existe",
            "observation.required"  => "O campo observação é obrigatório",
            "observation.string"    => "Esta observação é inválido",
        ];
    }

    //Relationship
    public function vehicle()
    {
        return $this->belongsTo('App\Models\Vehicle');
    }
}
