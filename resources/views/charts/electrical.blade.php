@extends('layouts.chart')
@section('title', $viewData["title"])
@section('content')
<div class="card">
  <div class="card-header">
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>

    <div id="main">
    <div id="clock"></div>
      <div id="dia" style="width: 100%; height: 600px;"></div>
    </div>

    <script type="text/javascript">
      setInterval(function() {
        let actualMoment = new Date();
        let date = actualMoment.toLocaleDateString();
        let hour = actualMoment.getHours();
        let minute = String(actualMoment.getMinutes()).padStart(2, '0');
        let secund = String(actualMoment.getSeconds()).padStart(2, '0');
        let actualTime = hour + ":" + minute + ":" + secund;
        let actualDateTime = date + " " + actualTime;
        document.getElementById('clock').innerHTML = actualDateTime;
      }, 1000);

      setInterval(function() {
                    window.location.replace("http://localhost:8000/electricalmes");
                },  14000);

      // Obtén los datos reales del controlador
      const consumoElectricoAyer = <?php echo json_encode($viewData['consumoElectricoAyer']); ?>;
      const consumoElectricoHoy = <?php echo json_encode($viewData['consumoElectricoHoy']); ?>;
      const chartNombreDiaAnterior = <?php echo json_encode($viewData["nombreDiaAnterior"]); ?>;
      const chartNombreDiaActual = <?php echo json_encode($viewData["nombreDiaActual"]); ?>;
      const consumosAnteriores = <?php echo json_encode($viewData['consumoSemanal']); ?>;

      console.log(consumosAnteriores);
      option = {
        xAxis: {
          type: 'category',
          data: <?php echo json_encode(array_merge($viewData['dayNames'], ['Media semanal'])); ?>
        },
        yAxis: {
          type: 'value'
        },
        series: [
          {
            data: [
              {
                value: consumosAnteriores[0],
                itemStyle: {
                  color: '#67DF5F'
                }
              },
              {
                value: consumosAnteriores[1],
                itemStyle: {
                  color: '#67DF5F'
                }
              },
              {
                value: consumosAnteriores[2],
                itemStyle: {
                  color: '#67DF5F'
                }
              },
              {
                value: consumosAnteriores[3],
                itemStyle: {
                  color: '#67DF5F'
                }
              },
              {
                value: consumosAnteriores[4],
                itemStyle: {
                  color: '#67DF5F'
                }
              },
              {
                value: consumosAnteriores[5],
                itemStyle: {
                  color: '#67DF5F'
                }
              },
              {
                value: consumoElectricoHoy,
                itemStyle: {
                  color: 'skyblue'
                }
              },
              {
                value: 16780,
                itemStyle: {
                  color: 'skyblue'
                }
              },
            ],
            type: 'bar',
            showBackground: true,
            backgroundStyle: {
              color: 'rgba(180, 180, 180, 0.2)'
            },
            label: {
              show: true,
              position: 'inside',
              formatter: '{c} m3'
            }
          }
        ]
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