<?php

namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceTypesValue;
use App\Models\ServiceType;

class ServiceTypesValuesController extends Controller
{
    public function index(){
        return view('management.values.index', ['service_types' => ServiceType::orderBy('name')->get()]);
    }

    public function actions(Request $request){
        switch($request->actionType){
            default: 
                return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Tipo não encontrado']];
                break;

            case 'add':
                if(ServiceTypesValue::create($request->all())){
                    return ['error' => false, 'alerts' => ['type' => 'success', 'text' => 'Adicionado']];
                }else{
                    return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Não adicionado']];
                }
                break;

            case 'consult':
                return view('management.values.list', ['values' => ServiceTypesValue::paginate(5)]);
                break;

            case 'show':
                if($value = ServiceTypesValue::find($request->id)){
                    return ['error' => false, 'alerts' => ['type' => 'success', 'text' => 'Recuperado'], 'value' => $value];    
                }else{
                    return ['error' => true, 'alerts' => ['type' => 'success', 'text' => 'Não encontrado']];
                }
                break;

            case 'update':
                $value = ServiceTypesValue::find($request->id);
                $value->service_type_id = $request->service_type_id;
                $value->value = $request->value;
                if($value->save()){
                    return ['error' => false, 'alerts' => ['type' => 'success', 'text' => 'Atualizado']];
                }else{
                    return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Não atualizado']];
                }
                break;

            case 'remove':
                if(ServiceTypesValue::destroy($request->id)){
                    return ['error' => false, 'alerts' => ['type' => 'success', 'text' => 'Removido']];
                }else{
                    return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Não removido']];
                }
                break;
        }
    }
}
