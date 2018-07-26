<?php

namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceType;

class ServiceTypesController extends Controller
{
    public function index(){
        return view('management.service_types.index');
    }

    public function actions(Request $request){
        switch($request->actionType){
            default: 
                return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Tipo não encontrado']];
                break;

            case 'add':
                if(ServiceType::create($request->all())){
                    return ['error' => false, 'alerts' => ['type' => 'success', 'text' => 'Adicionado']];
                }else{
                    return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Não adicionado']];
                }
                break;

            case 'consult':
                return view('management.service_types.list', ['service_types' => ServiceType::paginate(5)]);
                break;

            case 'show':
                if($service_type = ServiceType::find($request->id)){
                    return ['error' => false, 'alerts' => ['type' => 'success', 'text' => 'Recuperado'], 'service_type' => $service_type];    
                }else{
                    return ['error' => true, 'alerts' => ['type' => 'success', 'text' => 'Não encontrado']];
                }
                break;

            case 'update':
                $service_type = ServiceType::find($request->id);
                $service_type->code = $request->code;
                $service_type->name = $request->name;
                $service_type->value = $request->value;
                $service_type->time = $request->time;
                if($service_type->save()){
                    return ['error' => false, 'alerts' => ['type' => 'success', 'text' => 'Atualizado']];
                }else{
                    return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Não atualizado']];
                }
                break;

            case 'remove':
                if(ServiceType::destroy($request->id)){
                    return ['error' => false, 'alerts' => ['type' => 'success', 'text' => 'Removido']];
                }else{
                    return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Não removido']];
                }
                break;
        }
    }
}
