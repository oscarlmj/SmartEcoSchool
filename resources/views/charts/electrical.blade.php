@extends('layouts.chart')
@section('title', $viewData["title"])
@section('content')
<div class="card">
  <div class="card-header">
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>

    <div id="main">
      <div id="dia" style="width: 100%; height: 600px;"></div>
    </div>

    <script type="text/javascript">
      // Obtén los datos reales del controlador
      const consumoElectricoAyer = <?php echo json_encode($viewData['consumoElectricoAyer']); ?>;
      const consumoElectricoHoy = <?php echo json_encode($viewData['consumoElectricoHoy']); ?>;
      const chartNombreDiaAnterior = <?php echo json_encode($viewData["nombreDiaAnterior"]); ?>;
      const chartNombreDiaActual = <?php echo json_encode($viewData["nombreDiaActual"]); ?>;

      setInterval(function() {
                window.location.replace("http://localhost:8000/electricalmes");
                },  14000);

      let option = {
        xAxis: {
          type: 'category',
          data: [chartNombreDiaAnterior, chartNombreDiaActual]
        },
        yAxis: {
          type: 'value'
        },
        series: [{
          data: [
            {
              value:consumoElectricoAyer,
              itemStyle: {
                color: 'red'
              }
            },
            {
              value:consumoElectricoHoy
            }
          ],
          type: 'bar',
          label: {
                                show: true,
                                position: 'inside',
                                formatter: '{c} kw/h'
                            }
        }]
      };

      // Inicializar la instancia de ECharts con el elemento DOM
      const myChart = echarts.init(document.getElementById('dia'));

      // Mostrar el gráfico usando la configuración y los datos especificados.
      myChart.setOption(option);

      // Definir la función de actualización en tiempo real (simulada)
      function run() {
        // Puedes reemplazar esta función con la lógica real de actualización en tiempo real
        for (var i = 0; i < chartData.length; ++i) {
          if (Math.random() > 0.9) {
            chartData[i] += Math.round(Math.random() * 2000);
          } else {
            chartData[i] += Math.round(Math.random() * 200);
          }
        }

        // Actualizar la serie 'Consumo Eléctrico' con los nuevos datos
        myChart.setOption({
          series: [{
            type: 'bar',
            data: chartData
          }]
        });
      }

      // Simular la actualización en tiempo real
      setTimeout(function() {
        run();
      }, 0);
      setInterval(run, 3000);
    </script>
  </div>
</div>
@endsection