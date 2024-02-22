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
        
        // Obtener el consumo eléctrico del día anterior
        $consumoElectricoAyer = Measurement::where('id_sensor', 1)
            ->whereDate('fecha', now()->subDay())
            ->orderBy('fecha', 'desc')
            ->value('consumo');

        // Obtener el consumo eléctrico del día actual
        $consumoElectricoHoy = Measurement::where('id_sensor', 1)
            ->whereDate('fecha', now())
            ->orderBy('fecha', 'desc')
            ->value('consumo');

        // Nombre del dia actual y anterior
        $viewData["nombreDiaActual"] = now()->subDay()->locale('es')->dayName;
        $viewData["nombreDiaAnterior"] = now()->locale('es')->dayName;

        dd($consumoElectricoAyer, $consumoElectricoHoy);

        return view('charts.electrical')->with("viewData", $viewData);
    }

    public function electricalMes()
    {
        $viewData["title"] = "Consumo eléctrico";

        // Cambio: Recuperar el consumo eléctrico del mes pasado del primer y ultimo registro del mes
        $consumoElectricoActual = Measurement::where('id_sensor', 1)
            ->whereMonth('fecha', now()->subMonth()->month)
            ->whereYear('fecha', now()->subMonth()->year)
            ->orderBy('fecha', 'asc')
            ->value('consumo');

        $consumoElectricosAnterior = Measurement::where('id_sensor', 1)
            ->whereMonth('fecha', now()->subMonth()->month)
            ->whereYear('fecha', now()->subMonth()->year)
            ->orderBy('fecha', 'desc')
            ->value('consumo');

        $viewData["mesAnterior"] = $consumoElectricosAnterior - $consumoElectricoActual;

        // Cambio: Recuperar el consumo eléctrico del mes actual del primer y ultimo registro del mes
        $primerConsumoMesActual = Measurement::where('id_sensor', 1)
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->orderBy('fecha', 'asc')
            ->value('consumo');

        $ultimoConsumoMesActual = Measurement::where('id_sensor', 1)
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->orderBy('fecha', 'desc')
            ->value('consumo');

        $viewData["mesActual"] = $ultimoConsumoMesActual - $primerConsumoMesActual;

        $viewData["nombreMesActual"] = now()->subMonth()->locale('es')->monthName;
        $viewData["nombreMesAnterior"] = now()->locale('es')->monthName;

        return view('charts.electricalMes')->with("viewData", $viewData);
    }
}
