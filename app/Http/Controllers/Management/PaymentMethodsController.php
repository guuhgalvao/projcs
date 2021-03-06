<?php

namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\PaymentMethod;

class PaymentMethodsController extends Controller
{
    public function index(){
        return view('management.payment_methods.index');
    }

    public function actions(Request $request){
        switch($request->actionType){
            default: 
                return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Tipo não encontrado']];
                break;

            case 'add':
                try{
                    $payment_method = new PaymentMethod();
                    $validation = Validator::make($request->all(), $payment_method->rules('add'), $payment_method->messages());
                    if(!$validation->fails()){
                        if(PaymentMethod::create($request->all())){
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
                return view('management.payment_methods.list', ['payment_methods' => PaymentMethod::paginate(5)]);
                break;

            case 'show':
                if($payment_method = PaymentMethod::find($request->id)){
                    return ['error' => false, 'alerts' => ['type' => 'success', 'text' => 'Recuperado'], 'payment_method' => $payment_method];    
                }else{
                    return ['error' => true, 'alerts' => ['type' => 'success', 'text' => 'Não encontrado']];
                }
                break;

            case 'update':
                try{
                    $payment_method = new PaymentMethod();
                    $validation = Validator::make($request->all(), $payment_method->rules('update', $request), $payment_method->messages());
                    if(!$validation->fails()){
                        $payment_method = PaymentMethod::find($request->id);
                        $payment_method->code = $request->code;
                        $payment_method->name = $request->name;
                        $payment_method->card = isset($request->card) ? true : false;
                        if($payment_method->save()){
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
                if(PaymentMethod::destroy($request->id)){
                    return ['error' => false, 'alerts' => ['type' => 'success', 'text' => 'Removido']];
                }else{
                    return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Não removido']];
                }
                break;
        }
    }
}
