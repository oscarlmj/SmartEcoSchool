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
        $viewData["title"] = "Consumo de agua mensual"; // Título de la página

        //Recuperar el primer y último registro del mes pasado para calcular el consumo de agua.
        $firstInputLastMonth = Measurement::where('id_sensor', 2)
            ->whereMonth('fecha', now()->subMonth()->month)
            ->whereYear('fecha', now()->subMonth()->year)
            ->orderBy('fecha', 'asc')
            ->value('consumo');

        $lastInputLastMonth = Measurement::where('id_sensor', 2)
            ->whereMonth('fecha', now()->subMonth()->month)
            ->whereYear('fecha', now()->subMonth()->year)
            ->orderBy('fecha', 'desc')
            ->latest()
            ->value('consumo');

        $viewData["lastMonth"] = $lastInputLastMonth - $firstInputLastMonth;

        //Recuperar el primer y último registro del mes actual para calcular el consumo de agua.
        $firstInputCurrentMonth = Measurement::where('id_sensor', 2)
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->orderBy('fecha', 'asc')
            ->value('consumo');

        $lastInputCurrentMonth = Measurement::where('id_sensor', 2)
            ->whereDate('fecha', now())
            ->orderBy('fecha', 'desc')
            ->latest()
            ->value('consumo');

        $viewData["currentMonth"] = $lastInputCurrentMonth - $firstInputCurrentMonth;

        $viewData["lastMonthName"] = now()->subMonth()->locale('es')->monthName;
        $viewData["currentMonthName"] = now()->locale('es')->monthName;

        return view('charts.waterMonth')->with("viewData", $viewData);
    }

    public function electrical()
    {
        $viewData["title"] = "Consumo eléctrico";

        // Obtener el consumo eléctrico del día anterior
        $consumoElectricoAyer = Measurement::where('id_sensor', 1)
            ->whereDate('fecha', now()->subDay())
            ->orderBy('fecha', 'desc')
            ->value('consumo');

        $consumoElectricoAntesdeeayer = Measurement::where('id_sensor', 1)
            ->whereDate('fecha', now()->subDays(2))
            ->orderBy('fecha', 'desc')
            ->value('consumo');

        $consumoElectricoHoy = Measurement::where('id_sensor', 1)
            ->whereDate('fecha', now())
            ->orderBy('fecha', 'desc')
            ->value('consumo');

        
        // Nombre del dia actual y anterior
        $viewData["nombreDiaActual"] = now()->subDay()->locale('es')->dayName;
        $viewData["nombreDiaAnterior"] = now()->locale('es')->dayName;

        // Pasar los datos al view
        $viewData["consumoElectricoAyer"] = $consumoElectricoAyer - $consumoElectricoAntesdeeayer;
        $viewData["consumoElectricoHoy"] = $consumoElectricoHoy - $consumoElectricoAyer;

        return view('charts.electrical')->with("viewData", $viewData);
    }

    public function electricalMes()
    {
        $viewData["title"] = "Consumo eléctrico";

        // Cambio: Recuperar el consumo eléctrico del mes anterior del primer y ultimo registro del mes
        $primerConsumoMesAnterior = Measurement::where('id_sensor', 1)
        ->whereMonth('fecha', now()->subMonth()->month)
        ->whereYear('fecha', now()->subMonth()->year)
        ->orderBy('fecha', 'asc')
        ->value('consumo');

        $ultimoConsumoMesAnterior = Measurement::where('id_sensor', 1)
        ->whereMonth('fecha', now()->subMonth()->month)
        ->whereYear('fecha', now()->subMonth()->year)
        ->orderBy('fecha', 'desc')
        ->latest()
        ->value('consumo');

        $viewData["mesAnterior"] = $ultimoConsumoMesAnterior - $primerConsumoMesAnterior;
            
        // Cambio: Recuperar el consumo eléctrico del mes actual del primer y ultimo registro del mes
        $primerConsumoMesActual = Measurement::where('id_sensor', 1)
        ->whereMonth('fecha', now()->month)
        ->whereYear('fecha', now()->year)
        ->orderBy('fecha', 'asc')
        ->value('consumo');

        $ultimoConsumoMesActual = Measurement::where('id_sensor', 1)
        ->whereDate('fecha', now())
        ->orderBy('fecha', 'desc')
        ->latest()
        ->value('consumo');

        $viewData["mesActual"] = $ultimoConsumoMesActual - $primerConsumoMesActual;

        $viewData["nombreMesActual"] = now()->subMonth()->locale('es')->monthName;
        $viewData["nombreMesAnterior"] = now()->locale('es')->monthName;

        return view('charts.electricalMes')->with("viewData", $viewData);
    }
}
