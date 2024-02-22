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

    public function water()
    {
        $viewData["title"] = "Consumo de agua"; // Título de la página
        
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
    }