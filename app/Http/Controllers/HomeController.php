<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $results_per_page = 10;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home', ['services' => Service::where('finished_in', NULL)->paginate($this->results_per_page)]);
    }

    public function users()
    {
        return view('welcome');
    }

    public function actions(Request $request){
        switch($request->actionType){
            default: 
                return ['error' => true, 'alerts' => ['type' => 'danger', 'text' => 'Tipo não encontrado']];
                break;

            case 'consult':
                return view('home.lists.services', ['services' => Service::where('finished_in', NULL)->paginate($this->results_per_page)]);
                break;
        }
    }
}
