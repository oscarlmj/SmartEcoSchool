<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\echartController;

namespace App\Http\Controllers;

class indexController extends Controller
{
    public function index()
    {
        $viewData["title"] = "Dashboard"; // Título de la página


        return view('index')->with("viewData", $viewData);
    }
}
