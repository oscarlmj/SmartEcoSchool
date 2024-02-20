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
        $viewData["week"] = []; // Array para almacenar el consumo de agua de cada día de la semana actual
        
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

        //Recuperar el último consumo de agua de hoy.
        $lastInputToday = Measurement::where('id_sensor', 2)
            ->whereDate('fecha', now())
            ->orderBy('fecha', 'desc')
            ->latest()
            ->value('consumo');

        //Calcular el consumo de agua de hoy.
        $consumo = $lastInputToday - $lastInputYesterday;

        // Almacenar el consumo de agua de hoy en un archivo de texto.
        $lastModified = Carbon::createFromTimestamp(File::lastModified(Storage::disk('public')->path('consumption.txt')));
        
        if(!$lastModified->isToday()) {
            $file = Storage::disk('public')->get('consumption.txt');
            $file = $file . $consumo . ";";
            Storage::disk('public')->put('consumption.txt', $file);
        } else {
            $contenido = Storage::disk('public')->get('consumption.txt', $consumo . ";");
            $content = explode(";",$contenido);
            array_pop($content);
            array_push($content, $consumo);
            $contenido = implode(";", $content);

        }

        $viewData["week"] = explode(";", Storage::disk('public')->get('consumption.txt'));

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