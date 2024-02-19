<?php

namespace App\Http\Controllers;
use App\Models\Measurement;
use Illuminate\Http\Request;


class echartController extends Controller
{    

    public function water()
    {
        $viewData["title"] = "Consumo de agua"; // Título de la página
        $viewData["week"] = [];
        
        
        // Recuperar el primer y último registro de la semana pasada para calcular el consumo de agua.
            $primerRegistroSemana = Measurement::where('id_sensor', 2)
                ->whereDate('fecha', now()->subWeek()->startOfWeek())
                ->orderBy('fecha', 'asc')
                ->latest()
                ->value('consumo');

            $ultimoRegistroSemana = Measurement::where('id_sensor', 2)
                ->whereDate('fecha', now()->subWeek()->endOfWeek())
                ->orderBy('fecha', 'desc')
                ->latest()
                ->value('consumo');

            $viewData["semanaAnterior"] = $ultimoRegistroSemana - $primerRegistroSemana;


        //Recuperar el último consumo de agua de ayer.
        $lastInputYesterday = Measurement::where('id_sensor', 2)
            ->whereDate('fecha', now()->subDay())
            ->orderBy('fecha', 'desc')
            ->latest()
            ->value('consumo');

        $lastInputToday = Measurement::where('id_sensor', 2)
            ->whereDate('fecha', now())
            ->orderBy('fecha', 'desc')
            ->latest()
            ->value('consumo');

            
            
           
        if ($lastInputYesterday && $lastInputToday) {
            $currentDayOfWeek = date('N') - 1;
            $viewData["week"][$currentDayOfWeek] = $lastInputToday - $lastInputYesterday;
        }
        

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