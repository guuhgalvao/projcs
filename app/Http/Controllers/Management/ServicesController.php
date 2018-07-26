<?php

namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Models\Service;
use App\Models\Client;
use App\Models\ServiceType;
use App\Models\ServiceTypesValue;
use App\Models\PaymentMethod;
use App\Models\Vehicle;

class ServicesController extends Controller
{
    public function start(){
        return view('service.index', ['clients' => Client::all(), 'service_types' => ServiceType::all(), 'vehicles' => Vehicle::all()]);
    }

    public function finish(Request $request){
        return view('service.finish', ['service' => Service::find($request->service_id), 'payment_methods' => PaymentMethod::all()]);
    }

    public function vehicle(Request $request){
        return view('service.vehicle', ['service' => Service::find($request->service_id)]);
    }

    public function pdf(Request $request){
        // return \PDF::loadView('service.order', ['service' => Service::find(1)])
        //     ->setOptions(['isPhpEnabled' => true, 'isRemoteEnabled' => true, 'isHtml5ParserEnabled' => false])
        //     ->setPaper([0, 0, 164.409, 566,929], 'portrait')
        //     // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
        //     ->stream('voucher.pdf');

        return view('service.order', ['service' => Service::find(1)]);
    }

    public function index(){
        return view('management.services.index', ['clients' => Client::all(), 'service_types' => ServiceType::all(), 'vehicles' => Vehicle::all()]);
    }

    public function actions(Request $request){
        switch($request->actionType){
            default: 
                return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Tipo não encontrado']];
                break;

            case 'add':
                $service_type_attrs = explode('-', str_replace(' ', '', $request->service_types));
                $service_type = ServiceType::where('code', $service_type_attrs[0])->first();
                if(!empty($service_type)){
                    $vehicle = Vehicle::firstOrCreate(['plate' => strtoupper($request->vehicles)]);
                    if(!$vehicle->save()){
                        return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Falha ao salvar veículo']];
                    }
                    if(!empty($request->clients)){
                        $client = Client::firstOrCreate(['name' => $request->clients]);
                        if(!$client->save()){
                            return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Falha ao salvar cliente']];
                        }
                    }
                    $service = new Service();
                    $service->user_id = Auth::id();
                    $service->service_type_id = $service_type->id;
                    $service->vehicle_id = $vehicle->id;
                    if(!empty($request->clients)){
                        $service->client_id = $client->id;
                    }
                    $service->order = date('Ymd').(Service::max('id')+1);
                    $service->value = $request->value;
                    $service->annotations = $request->annotations;
                    $service->status = 1;
                    $service->started_in = $request->started_in;
                    $service->started_path = "public/services/orders/started_$service->order.pdf";
                    if($service->save()){
                        //$pdf = \PDF::loadView('service.order', ['service' => Service::find($service->id)])->setOptions(['isPhpEnabled' => true, 'isRemoteEnabled' => true, 'isHtml5ParserEnabled' => false])->setPaper([0, 0, 164.409, 566,929], 'portrait');
                        // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
                        if(Storage::put($service->started_path, \PDF::loadView('service.order', ['service' => Service::find($service->id)])->setOptions(['isPhpEnabled' => true, 'isHtml5ParserEnabled' => false])->setPaper([0, 0, 164.409, 566,929], 'portrait')->output())){
                        //if(Storage::put($service->started_path, \PDF::loadFile(Storage::url("public/services/orders/started_$service->order.html"))->setOptions(['isPhpEnabled' => true, 'isHtml5ParserEnabled' => true])->setPaper([0, 0, 164.409, 566,929])->output())){
                            if(empty($vehicle->brand)){
                                return ['error' => false, 'alerts' => ['type' => 'success', 'text' => "Serviço adicionado"], 'redirect' => url()->route('service_vehicle', ['service_id' => $service->id]), 'vehicle' => true];
                            }else{
                                return ['error' => false, 'alerts' => ['type' => 'success', 'text' => "Serviço adicionado. Ordem: <b>$service->order</b><br/><br/><a href='".url('/').Storage::url($service->started_path)."' target='_blank' class='btn btn-info'>Abrir Ordem</a>"], 'redirect' => url()->route('home'), 'vehicle' => true];
                            }
                        }else{
                            return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Não foi possível gerar o comprovante']];    
                        }
                    }else{
                        return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Não adicionado']];
                    }
                }else{
                    return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Serviço não encontrado']];
                }
                break;

            case 'finalize':
                $service = Service::find($request->id);
                $service->finished_in = $request->finished_in;
                $service->value = $request->value;
                $service->payment_method_id = $request->payment_method_id;
                $service->finished_path = "public/services/vouchers/finished_$service->order.pdf";
                if($service->save()){
                    $pdf = \PDF::loadView('service.voucher', ['service' => Service::find($service->id)])
                    ->setOptions(['isPhpEnabled' => true, 'isRemoteEnabled' => true, 'isHtml5ParserEnabled' => false])
                    ->setPaper([0, 0, 164.409, 566,929], 'portrait');
                    // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
                    if(Storage::put($service->finished_path, $pdf->output())){
                        return ['error' => false, 'alerts' => ['type' => 'success', 'text' => "Serviço finalizado<br/><br/><a href='".url('/').Storage::url($service->finished_path)."' target='_blank' class='btn btn-info'>Abrir Comprovante</a>"], 'redirect' => url()->route('home')];
                    }else{
                        return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Não adicionado']];    
                    }
                }else{
                    return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Não adicionado']];
                }
                break;

            case 'consult':
                return view('management.services.list', ['services' => Service::paginate(5)]);
                break;

            case 'show':
                if($service = Service::find($request->id)){
                    return ['error' => false, 'alerts' => ['type' => 'success', 'text' => 'Recuperado'], 'service' => $service];    
                }else{
                    return ['error' => true, 'alerts' => ['type' => 'success', 'text' => 'Não encontrado']];
                }
                break;

            case 'update':
                if(Service::find($request->id)->update($request->all())){
                    return ['error' => false, 'alerts' => ['type' => 'success', 'text' => 'Atualizado']];
                }else{
                    return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Não atualizado']];
                }
                break;

            case 'remove':
                if(Service::destroy($request->id)){
                    return ['error' => false, 'alerts' => ['type' => 'success', 'text' => 'Removido']];
                }else{
                    return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Não removido']];
                }
                break;

            case 'save_vehicle':
                if($vehicle = Vehicle::find($request->id)){
                    $vehicle->plate = strtoupper($request->plate);
                    $vehicle->brand = $request->brand;
                    $vehicle->model = $request->model;
                    $vehicle->color = $request->color;
                    if($vehicle->save()){
                        $service = Service::find($request->service_id);
                        return ['error' => false, 'alerts' => ['type' => 'success', 'text' => "Atualizado. Ordem: <b>$service->order</b><br/><br/><a href='".url('/').Storage::url($service->started_path)."' target='_blank' class='btn btn-info'>Abrir Ordem</a>"], 'redirect' => url()->route('home')];
                    }else{
                        return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Não atualizado']];
                    }
                }else{
                    return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Veículo não encontrado']];
                }
                break;

            case 'get_service_types':
                $data = [];
                foreach(ServiceType::all() as $service){
                    array_push($data, $service->code.' - '.$service->name);
                }
                return response()->json($data);
                break;

            case 'get_vehicles':
                $data = [];
                foreach(Vehicle::all() as $vehicle){
                    array_push($data, $vehicle->plate);
                }
                return response()->json($data);
                break;

            case 'get_clients':
                $data = [];
                foreach(Client::all() as $client){
                    array_push($data, $client->name);
                }
                return response()->json($data);
                break;

            case 'get_value':
                $service_type_attrs = explode('-', str_replace(' ', '', $request->service_types));
                $service_type = ServiceType::where('code', $service_type_attrs[0])->first();
                $service_type_value = ServiceTypesValue::where('service_type_id', $service_type->id)->orderBy('created_at', 'desc')->first();
                return !empty($service_type_value->value) ? $service_type_value->value : $service_type->value;
                break;
        }
    }
}
