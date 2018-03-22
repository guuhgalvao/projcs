<?php

namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;

class ClientsController extends Controller
{
    
    public function index(){
        return view('management.clients.index');
    }
}
