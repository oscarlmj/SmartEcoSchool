@extends('layouts.chart')
@section('title', $viewData["title"])
@section('content')
<div class="card">
  <div class="card-header">
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>

    <div id="main">
      <div id="week" style="width: 100%; height: 600px;"></div>
    </div>


    <script type="text/javascript">
      const chartData = <?php echo json_encode($viewData["data"]); ?>;

      let option = {
        title: {
          left: 'center',
          text: 'Consumo eléctrico'
        },
        legend: {
          top: 'bottom',
          data: ['Consumo Eléctrico']
        },
        tooltip: {
          triggerOn: 'none',
          position: function(pt) {
            return [pt[0], 130];
          }
        },
        xAxis: {
          type: 'category',
          data: chartData.map(item => item[0]),
          axisPointer: {
            snap: true,
            lineStyle: {
              color: '#7581BD',
              width: 2
            },
            label: {
              show: true,
              formatter: function(params) {
                return echarts.format.formatTime('HH:mm', params.value);
              },
              backgroundColor: '#7581BD'
            }
          },
          splitLine: {
            show: false
          }
        },
        yAxis: {
          type: 'value',
          axisTick: {
            inside: true
          },
          splitLine: {
            show: false
          },
          axisLabel: {
            inside: true,
            formatter: '{value}\n'
          },
          z: 10
        },
        grid: {
          top: 110,
          left: 15,
          right: 15,
          height: 160
        },
        dataZoom: [{
          type: 'inside',
          throttle: 50
        }],
        series: [{
            name: 'Consumo Eléctrico',
            type: 'line',
            smooth: true,
            symbol: 'circle',
            symbolSize: 5,
            sampling: 'average',
            itemStyle: {
              color: '#0770FF'
            },
            stack: 'a',
            areaStyle: {
              color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                  offset: 0,
                  color: 'rgba(58,77,233,0.8)'
                },
                {
                  offset: 1,
                  color: 'rgba(58,77,233,0.3)'
                }
              ])
            },
            data: chartData
          },
          {
            name: 'Fake Data',
            type: 'line',
            smooth: true,
            stack: 'a',
            symbol: 'circle',
            symbolSize: 5,
            sampling: 'average',
            itemStyle: {
              color: '#F2597F'
            },
            areaStyle: {
              color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                  offset: 0,
                  color: 'rgba(213,72,120,0.8)'
                },
                {
                  offset: 1,
                  color: 'rgba(213,72,120,0.3)'
                }
              ])
            },
            data: chartData
          }
        ]
      };

      // Inicializar echarts instance con el elemento DOM
      const myChart = echarts.init(document.getElementById('week'));

      // Display the chart using the configuration items and data just specified.
      myChart.setOption(option);
    </script>
  </div>
</div>
@endsection