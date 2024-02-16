<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class echartController extends Controller
{
    public function water(){
        $viewData = [];
        $viewData["title"] = "Consumo de agua";

        return view('charts.water')->with("viewData", $viewData);
    }
}
