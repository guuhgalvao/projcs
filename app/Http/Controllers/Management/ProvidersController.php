<?php

namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProvidersController extends Controller
{
    public function index(){
        return view('management.providers.index');
    }
}
