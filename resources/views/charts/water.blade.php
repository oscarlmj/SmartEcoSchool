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
      let actual = 10000*100/totalAnterior;
      let color = actual >= 80 ? 'red' : (actual > 50 ? 'orange' : 'rgb(145,204,117)');      
      let myChart = echarts.init(document.getElementById('week'));

      // Specify the configuration items and data for the chart
      let option = gaugeData = [
      {
        value: actual,
        name: 'Semana actual',
        title: {
          offsetCenter: ['0%', '-30%']
        },
        detail: {
          valueAnimation: true,
          offsetCenter: ['0%', '-20%'],
          formatter: function(value) {
            return value.toFixed(2) + '%';
          },
          //Cambiar el color del % dependiendo del valor.
            color: color
        }
      },
      {
        value: totalAnterior,
        name: 'Semana anterior',
        title: {
          offsetCenter: ['0%', '0%']
        },
        detail: {
          valueAnimation: true,
          offsetCenter: ['0%', '10%'],
          formatter: '{value} m3'
        }
      }
    ];
option = {
  series: [
    {
      type: 'gauge',
      startAngle: 100,
      endAngle: -270,
      pointer: {
        show: false
      },
      progress: {
        show: true,
        overlap: false,
        roundCap: true,
        clip: false,
        itemStyle: {
          borderWidth: 0,
          borderColor: '#464646',
        }
      },
      axisLine: {
        lineStyle: {
          width: 50
        }
      },
      splitLine: {
        show: false,
        distance: 0,
        length: 10
      },
      axisTick: {
        show: false
      },
      axisLabel: {
        show: false,
        distance: 20
      },
      data: gaugeData,
      title: {
        fontSize: 16
      },
      detail: {
        width: 85,
        height: 14,
        fontSize: 18,
        color: 'inherit',
        borderColor: 'inherit',
        borderRadius: 20,
        borderWidth: 1,
      }
    }
  ]
};

      // Display the chart using the configuration items and data just specified.
      myChart.setOption(option);

    </script>
  </div>
</div>
@endsection