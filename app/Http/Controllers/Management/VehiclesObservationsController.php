<?php

namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\VehiclesObservation;
use App\Models\Vehicle;

class VehiclesObservationsController extends Controller
{
    private $results_per_page = 10;

    public function index(){
        return view('management.vehicles_observations.index', ['vehicles' => Vehicle::orderBy('id', 'desc')->get()]);
    }

    public function actions(Request $request){
        switch($request->actionType){
            default: 
                return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Tipo não encontrado']];
                break;

            case 'add':
                try{
                    $vehicle_observation = new VehiclesObservation();
                    $validation = Validator::make($request->all(), $vehicle_observation->rules('add'), $vehicle_observation->messages());
                    if(!$validation->fails()){
                        if(VehiclesObservation::create($request->all())){
                            return ['error' => false, 'alerts' => ['type' => 'success', 'text' => 'Adicionado']];
                        }else{
                            return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Não adicionado']];
                        }
                    }else{
                        return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => $validation->errors()->all()]];
                    }
                } catch(Exception $e){
                    return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => "FAILED: $e."]];
                }
                break;

            case 'consult':
                $vehicles_observations = (new VehiclesObservation)->newQuery();
                if(!empty($request->vehicle_id)){
                    $vehicles_observations->where('vehicle_id', $request->vehicle_id);
                }
                return view('management.vehicles_observations.list', ['vehicles_observations' => $vehicles_observations->orderBy('created_at', 'desc')->paginate($this->results_per_page)]);
                break;

            case 'show':
                if($vehicle_observation = VehiclesObservation::find($request->id)){
                    return ['error' => false, 'alerts' => ['type' => 'success', 'text' => 'Recuperado'], 'vehicle_observation' => $vehicle_observation];    
                }else{
                    return ['error' => true, 'alerts' => ['type' => 'success', 'text' => 'Não encontrado']];
                }
                break;

            case 'update':
                try{
                    $vehicle_observation = new VehiclesObservation();
                    $validation = Validator::make($request->all(), $vehicle_observation->rules('update'), $vehicle_observation->messages());
                    if(!$validation->fails()){
                        if(VehiclesObservation::find($request->id)->update($request->all())){
                            return ['error' => false, 'alerts' => ['type' => 'success', 'text' => 'Atualizado']];
                        }else{
                            return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Não atualizado']];
                        }
                    }else{
                        return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => $validation->errors()->all()]];
                    }
                } catch(Exception $e){
                    return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => "FAILED: $e."]];
                }
                break;

            case 'remove':
                if(VehiclesObservation::destroy($request->id)){
                    return ['error' => false, 'alerts' => ['type' => 'success', 'text' => 'Removido']];
                }else{
                    return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Não removido']];
                }
                break;
        }
    }
}
