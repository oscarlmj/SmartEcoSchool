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
