<?php

namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Client;
use App\Models\State;
use App\Models\City;

class ClientsController extends Controller
{
    
    public function index(){
        return view('management.clients.index', ['states' => State::orderBy('name')->get()]);
    }

    public function actions(Request $request){
        switch($request->actionType){
            default: 
                return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Tipo não encontrado']];
                break;

            case 'add':
                try{
                    $client = new Client();
                    $validation = Validator::make($request->all(), $client->rules('add'), $client->messages());
                    if(!$validation->fails()){
                        if(Client::create($request->all())){
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
                return view('management.clients.list', ['clients' => Client::paginate(1)]);
                break;

            case 'show':
                if($client = Client::find($request->id)){
                    return ['error' => false, 'alerts' => ['type' => 'success', 'text' => 'Recuperado'], 'client' => $client];    
                }else{
                    return ['error' => true, 'alerts' => ['type' => 'success', 'text' => 'Não encontrado']];
                }
                break;

            case 'update':
                try{
                    $client = new Client();
                    $validation = Validator::make($request->all(), $client->rules('update', $request), $client->messages());
                    if(!$validation->fails()){
                        if(Client::find($request->id)->update($request->all())){
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
                if(Client::destroy($request->id)){
                    return ['error' => false, 'alerts' => ['type' => 'success', 'text' => 'Removido']];
                }else{
                    return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Não removido']];
                }
                break;

            case 'cities':
                return City::where('state_id', $request->state_id)->get();
                break;
        }
    }
}
