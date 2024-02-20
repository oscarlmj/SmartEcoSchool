<?php

namespace App\Http\Controllers;
use App\Models\Measurement;
use Illuminate\Http\Request;


class echartController extends Controller
{    


    public function water()
    {
        $viewData["title"] = "Consumo de agua"; // Título de la página
        $sensorId = 2; // Reemplaza esto con el ID del sensor que deseas
        $startDate = now()->subWeek()->startOfWeek(); // Fecha de inicio es el inicio de la semana pasada
        $endDate = now()->subWeek()->endOfWeek(); // Fecha de fin es el final de la semana pasada
        
        $inicio = Measurement::where('id_sensor', 2)
            ->where('fecha', '2023-02-14 23:00:00')
            ->value('consumo');


        $fin = Measurement::where('id_sensor', 2)
            ->where('fecha', '2023-02-15 23:00:00')
            ->value('consumo');

            
        $viewData["semanaAnterior"] = $fin - $inicio; // Consumo de agua de la semana pasada

        // Perform action every 55 minutes
        $interval = 55 * 60; // 55 minutes in seconds
        $timer = time() % $interval;
        if ($timer === 0) {
            
        }

        $lastInput = Measurement::where('id_sensor', 2)
            ->orderBy('fecha', 'desc')
            ->limit(2)
            ->pluck('consumo')
            ->toArray();

        $viewData["lastInput"] = $lastInput[0] - $lastInput[1];


        return view('charts.water')->with("viewData", $viewData);
    }
}