@extends('layouts.chart')
@section('title', $viewData["title"])
@section('content')
<div class="card">
  <div class="card-header">
    Consumo de agua
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>

    <div id="main">
    <div id="week" style="width: 100%;height:500px;"></div>
    </div>


<script type="text/javascript">

      let totalAnterior = <?php echo json_encode($viewData["semanaAnterior"]); ?>;      // Initialize the echarts instance based on the prepared dom
      let actual = 100000*100/totalAnterior; // Valores de prueba
      let color = actual >= 80 ? 'red' : (actual > 50 ? 'orange' : 'rgb(145,204,117)');      
      let myChart = echarts.init(document.getElementById('week'));

      // Specify the configuration items and data for the chart
      let option = {
  xAxis: {
    data: ['SEMANA ACTUAL', 'SEMANA ANTERIOR']
  },
  yAxis: {},
  series: [
    {
      data: [7500, { value: 56000, label: 'TOTAL' }],
      type: 'bar',
      stack: 'x',
      label: {
        show: true,
        position: 'inside',
        formatter: function(params) {
          let days = ['Lunes'];
          return days[params.dataIndex];
        }
      }
    },
    {
      data: [8600],
      type: 'bar',
      stack: 'x',
      label: {
        show: true,
        position: 'inside',
        formatter: function(params) {
          let days = ['Martes'];
          return days[params.dataIndex];
        }
      }
    },
    {
      data: [9500],
      type: 'bar',
      stack: 'x',
      label: {
        show: true,
        position: 'inside',
        formatter: function(params) {
          let days = ['Miercoles'];
          return days[params.dataIndex];
        }
      }
    },
    {
      data: [8300],
      type: 'bar',
      stack: 'x',
      label: {
        show: true,
        position: 'inside',
        formatter: function(params) {
          let days = ['Jueves'];
          return days[params.dataIndex];
        }
      }
    },
    {
      data: [6800],
      type: 'bar',
      stack: 'x',
      label: {
        show: true,
        position: 'inside',
        formatter: function(params) {
          let days = ['Viernes'];
          return days[params.dataIndex];
        }
      }
    },
    {
      data: [8800],
      type: 'bar',
      stack: 'x',
      label: {
        show: true,
        position: 'inside',
        formatter: function(params) {
          let days = ['Sabado'];
          return days[params.dataIndex];
        }
      }
    },
    {
      data: [4800],
      type: 'bar',
      stack: 'x',
      label: {
        show: true,
        position: 'inside',
        formatter: function(params) {
          let days = ['Domingo'];
          return days[params.dataIndex];
        }
      }
    },
  ]
};

      // Display the chart using the configuration items and data just specified.
      myChart.setOption(option);

    </script>
  </div>
</div>
@endsection