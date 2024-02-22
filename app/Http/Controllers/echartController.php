<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Exception;

class echartController extends Controller
{

    public function waterWeek()
    {
        $viewData["title"] = "Consumo de agua semanal"; // Título de la página
        
        //Recuperar el primer y último registro de la semana pasada para calcular el consumo de agua.
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

        // Obtener el primer registro de la semana actual para calcular el consumo de agua de hoy
        $primerRegistroSemana = Measurement::where('id_sensor', 2)
            ->whereDate('fecha', now()->startOfWeek())
            ->orderBy('fecha', 'asc')
            ->latest()
            ->value('consumo');

        // Obtener el último consumo de agua de hoy
        $lastInputToday = Measurement::where('id_sensor', 2)
            ->whereDate('fecha', now())
            ->orderBy('fecha', 'desc')
            ->latest()
            ->value('consumo');



        // Comprobar que exista mas de un registro en la misma semana.
        $dataEntriesThisWeek = Measurement::where('id_sensor', 2)
            ->whereBetween('fecha', [now()->startOfWeek(), now()])
            ->count();
        //Si hay mas de un registro, se calcula el consumo de agua de la semana actual.
        if ($dataEntriesThisWeek > 1) {
            $viewData["consumoSemanal"] = $lastInputToday - $primerRegistroSemana;
            //Si no, se muestra el consumo de agua de este dia con respecto al ultimo registro de la semana
        } else {
            $viewData["consumoSemanal"] = $primerRegistroSemana - $ultimoRegistroSemana;
        }
                    
        return view('charts.water')->with("viewData", $viewData);
    }

    //Funcion para recoger y mostrar el consumo de agua mensual.
    public function waterMonth()
    {
        $viewData["title"] = "Consumo eléctrico";
    $viewData["week"] = [];

    // Cambio: Recuperar el consumo eléctrico del día 15 de febrero de 2023 por hora
    $consumoElectricosFeb = Measurement::where('id_sensor', 1)
        ->whereDate('fecha', '2023-02-14')
        ->orderBy('fecha', 'asc')
        ->get(['fecha', 'consumo']);

    // Convierte los datos al formato adecuado para ECharts
    $data = [];
    foreach ($consumoElectricosFeb as $consumoElectrico) {
        // Cambio: Usar formato 'H:i' para mostrar horas y minutos
        $data[] = [$consumoElectrico->fecha->format('H:i'), $consumoElectrico->consumo];
    }

    $viewData["data"] = $data;

    return view('charts.electrical')->with("viewData", $viewData);

    }
}