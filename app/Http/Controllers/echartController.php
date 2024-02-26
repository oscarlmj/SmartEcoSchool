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

        $consumoSemanal = [];

        for ($i = 0; $i < 6; $i++) {
            //Recuperar el primer y último registro de la semana pasada para calcular el consumo de agua.
            $primerRegistroSemana = Measurement::where('id_sensor', 2)
                ->whereDate('fecha', now()->subWeeks($i)->startOfWeek())
                ->orderBy('fecha', 'asc')
                ->latest()
                ->value('consumo');

            $ultimoRegistroSemana = Measurement::where('id_sensor', 2)
                ->whereDate('fecha', now()->subWeeks($i)->endOfWeek())
                ->orderBy('fecha', 'desc')
                ->latest()
                ->value('consumo');

            // Generate random values between 5000 and 8000
            $randomValue = rand(5000, 8000);
            $consumoSemanal[$i] = $randomValue;
        }

        //Almacena en cada posicion el consumo de agua de cada semana.
        $viewData["consumoSemanal"] = $consumoSemanal;

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

        //Almacena el consumo de agua de la semana pasada.
        $viewData["semanaAnterior"] = $ultimoRegistroSemana - $primerRegistroSemana;

        //Recuperar el primer y último registro de la semana actual para calcular el consumo de agua.
        $primerRegistroSemana = Measurement::where('id_sensor', 2)
            ->whereDate('fecha', now()->startOfWeek())
            ->orderBy('fecha', 'asc')
            ->latest()
            ->value('consumo');

        $lastInputToday = Measurement::where('id_sensor', 2)
            ->whereDate('fecha', now())
            ->orderBy('fecha', 'desc')
            ->latest()
            ->value('consumo');

        //Comprobar que exista mas de un registro en la misma semana.
        $dataEntriesThisWeek = Measurement::where('id_sensor', 2)
            ->whereBetween('fecha', [now()->startOfWeek(), now()])
            ->count();

        //Si hay mas de un registro, se calcula el consumo de agua de la semana actual.
        if ($dataEntriesThisWeek > 1) {
            $viewData["consumoActual"] = $lastInputToday - $primerRegistroSemana;
            //Si no, se muestra el consumo de agua de este dia con respecto al ultimo registro de la semana
        } else {
            $viewData["consumoActual"] = $primerRegistroSemana - $ultimoRegistroSemana;
        }

        //Devuelve el numero de semana del año.
        $viewData["weekNumbers"] = [
            now()->subWeeks(5)->locale('es')->weekOfYear,
            now()->subWeeks(4)->locale('es')->weekOfYear,
            now()->subWeeks(3)->locale('es')->weekOfYear,
            now()->subWeeks(2)->locale('es')->weekOfYear,
            now()->subWeeks(1)->locale('es')->weekOfYear,
            now()->locale('es')->weekOfYear
        ];

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
        //Almacena el consumo de agua del mes actual.
        $viewData["currentMonth"] = $lastInputCurrentMonth - $firstInputCurrentMonth;

        //Devuelve el nombre del mes pasado y el mes actual.
        $viewData["lastMonthName"] = now()->subMonth()->locale('es')->monthName;
        $viewData["currentMonthName"] = now()->locale('es')->monthName;

        return view('charts.waterMonth')->with("viewData", $viewData);
    }

    public function electrical()
    {
        $viewData["title"] = "Consumo eléctrico";

        $consumoSemanal = [];

        for ($i = 0; $i <= 6; $i++) {
            //Recuperar el primer y último registro de la semana pasada para calcular el consumo de agua.
            $primerRegistroDia = Measurement::where('id_sensor', 1)
                ->whereDate('fecha', now()->subDays($i))
                ->orderBy('fecha', 'asc')
                //->first()
                ->value('consumo');

            $ultimoRegistroDia = Measurement::where('id_sensor', 1)
                ->whereDate('fecha', now()->subDays($i))
                ->orderBy('fecha', 'desc')
                //->latest()
                ->value('consumo');

            // Generate random values between 5000 and 8000
            $randomValue = rand(5000, 8000);
            $consumoSemanal[$i] = $randomValue;
        }

$viewData["dayNames"] = [
    now()->subDays(6)->locale('es')->dayName,
    now()->subDays(5)->locale('es')->dayName,
    now()->subDays(4)->locale('es')->dayName,
    now()->subDays(3)->locale('es')->dayName,
    now()->subDays(2)->locale('es')->dayName,
    now()->subDays(1)->locale('es')->dayName,
    now()->locale('es')->dayName
];
        

        //Almacena en cada posicion el consumo de agua de cada semana.
        $viewData["consumoSemanal"] = $consumoSemanal;

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

        $viewData["monthNames"] = [
            now()->subMonth(1)->locale('es')->monthName,
            now()->subMonth(2)->locale('es')->monthName,
            now()->subMonth(3)->locale('es')->monthName,
            now()->subMonth(4)->locale('es')->monthName,
            now()->subMonth(5)->locale('es')->monthName,
            now()->subMonth(6)->locale('es')->monthName,
            now()->subMonth(7)->locale('es')->monthName,
            now()->subMonth(8)->locale('es')->monthName,
            now()->subMonth(9)->locale('es')->monthName,
            now()->subMonth(10)->locale('es')->monthName,
            now()->subMonth(11)->locale('es')->monthName
        ];


        $consumoMesesAnteriores = [];
        for ($i = 0; $i <= 10; $i++) {
            $primerConsumoMesAnterior = Measurement::where('id_sensor', 1)
                ->whereMonth('fecha', now()->subMonths($i)->month)
                ->whereYear('fecha', now()->subMonths($i)->year)
                ->orderBy('fecha', 'asc')
                ->value('consumo');

            $ultimoConsumoMesAnterior = Measurement::where('id_sensor', 1)
                ->whereMonth('fecha', now()->subMonths($i)->month)
                ->whereYear('fecha', now()->subMonths($i)->year)
                ->orderBy('fecha', 'desc')
                ->latest()
                ->value('consumo');

            //$consumoMesesAnteriores[$i] = $ultimoConsumoMesAnterior - $primerConsumoMesAnterior;
            $randomValue = rand(10000, 50000);

            $consumoMesesAnteriores[$i] = $randomValue;
        }
        $viewData["consumoMesesAnteriores"] = $consumoMesesAnteriores;


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

        $viewData["nombreMesActual"] = now()->locale('es')->monthName;
        $viewData["nombreMesAnterior"] = now()->locale('es')->monthName;

        return view('charts.electricalMes')->with("viewData", $viewData);
    }
}
