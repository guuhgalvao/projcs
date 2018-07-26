<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Exports\ReportsServices;
use App\Models\Service;
use App\User;

class ServicesController extends Controller
{
    private $results_per_page = 10;

    public function index(){
        return view('reports.services.index', ['services' => Service::orderBy('created_at', 'asc')->paginate($this->results_per_page), 'users' => User::orderBy('name', 'asc')->get()]);
    }

    public function actions(Request $request){
        switch($request->actionType){
            default: 
                return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Tipo não encontrado']];
                break;

            case 'filter':
                $services = (new Service)->newQuery();
                if(!empty($request->start) && !empty($request->end)){
                    $services->whereBetween('started_in', [Carbon::createFromFormat('m-d-Y', $request->start)->format('Y-m-d 00:00:00'), Carbon::createFromFormat('m-d-Y', $request->end)->format('Y-m-d 23:59:59')]);
                    //$services->whereBetween('finished_in', [Carbon::createFromFormat('m-d-Y', $request->start)->format('Y-m-d 00:00:00'), Carbon::createFromFormat('m-d-Y', $request->end)->format('Y-m-d 23:59:59')]);
                }
                if(!empty($request->user)){
                    $services->where('user_id', $request->user);
                }
                if($request->export == 'true'){
                    $filepath = 'public/services/exports/'.date('YmdHis').'.xlsx';
                    if((new ReportsServices($services->orderBy('created_at', 'desc')->get()))->store($filepath)){
                        return ['error' => false, 'message' => ['type' => 'success', 'text' => 'OK'], 'path' => url('/').Storage::url($filepath)];
                    }else{
                        return ['error' => true, 'message' => ['type' => 'success', 'text' => 'ERROR']];
                    }
                }else{
                    return view('reports.services.list', ['services' => $services->orderBy('created_at', 'desc')->paginate($this->results_per_page)]);
                }
                break;
        }
    }
}
