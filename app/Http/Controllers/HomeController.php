<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $viewData = [];
        $viewData["title"] = "Smart Eco School";

        return view("home.index")->with("viewData", $viewData);
    }
}
