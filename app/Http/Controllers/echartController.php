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

        return view('charts.water')->with("viewData", $viewData);
    }

    public function electrical()
    {
        $viewData["title"] = "Consumo eléctrico"; // Título de la página
        $sensorId = 1; // Reemplaza esto con el ID del sensor que deseas
        $startDate = now()->subWeek()->startOfWeek(); // Fecha de inicio es el inicio de la semana pasada
        $endDate = now()->subWeek()->endOfWeek(); // Fecha de fin es el final de la semana pasada

        $inicio = Measurement::where('id_sensor', 1)
            ->where('fecha', '2023-02-14 23:00:00')
            ->value('consumo');


        $fin = Measurement::where('id_sensor', 1)
            ->where('fecha', '2023-02-15 23:00:00')
            ->value('consumo');
            
        $viewData["semanaAnterior"] = $fin - $inicio; // Consumo de agua de la semana pasada

        return view('charts.electrical')->with("viewData", $viewData);
    }
}