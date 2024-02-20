@extends('layouts.chart')
@section('title', $viewData["title"])
@section('content')
<div class="card">
  <div class="card-header">
    Consumo de agua
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>

    <div id="main">
      <div id="week" style="width: 100%; height: 600px;"></div>
    </div>


    <script type="text/javascript">
      let totalAnterior = <?php echo json_encode($viewData["semanaAnterior"]); ?>; // Initialize the echarts instance based on the prepared dom
      let myChart = echarts.init(document.getElementById('week'));
      let rojo = 'rgb(231,76,60)';
      let amarillo = 'rgb(243,156,18)';
      let verde = 'rgb(46,204,113)';

      // Specify the configuration items and data for the chart
      let option = {
        
        xAxis: {
          data: ['SEMANA ACTUAL', 'SEMANA ANTERIOR']
        },
        yAxis: {},
        series: [{
            data: [
              8500,
              {
                value: totalAnterior,
                label: {
                  show: true,
                  position: 'inside',
                  formatter: totalAnterior + ' m3'
                }
              }
            ],
            itemStyle: {
              color: function(params) {
                if (params.data >= 8000) {
                  return rojo;
                } else if (params.data > 6000) {
                  return amarillo;
                } else if (params.data < 6000) {
                  return verde;
                } else {
                  return 'skyblue';
                }
              }
            },
            type: 'bar',
            stack: 'x',
            label: {
              show: true,
              position: 'inside',
              formatter: function(params) {
                return 'Lunes' + ' ' + params.value + ' m3';
              }
            }
          },
          {
            data: [
              6250,
              {
                label: {
                  show: true,
                  position: 'inside',
                  formatter: totalAnterior + ' m3'
                }
              }
            ],
            itemStyle: {
              color: function(params) {
                if (params.data >= 8000) {
                  return rojo;
                } else if (params.data > 6000) {
                  return amarillo;
                } else {
                  return verde;
                }
              }
            },
            type: 'bar',
            stack: 'x',
            label: {
              show: true,
              position: 'inside',
              formatter: function(params) {
                return 'Martes' + ' ' + params.value + ' m3';
              }
            }
          },
          {
            data: [
              8000,
              {
                label: {
                  show: true,
                  position: 'inside',
                  formatter: totalAnterior + ' m3'
                }
              }
            ],
            itemStyle: {
              color: function(params) {
                if (params.data >= 8000) {
                  return rojo;
                } else if (params.data > 6000) {
                  return amarillo;
                } else {
                  return verde;
                }
              }
            },
            type: 'bar',
            stack: 'x',
            label: {
              show: true,
              position: 'inside',
              formatter: function(params) {
                return 'Miercoles' + ' ' + params.value + ' m3';
              }
            }
          },
          {
            data: [
              9000,
              {
                label: {
                  show: true,
                  position: 'inside',
                  formatter: totalAnterior + ' m3'
                }
              }
            ],
            itemStyle: {
              color: function(params) {
                if (params.data >= 8000) {
                  return rojo;
                } else if (params.data > 6000) {
                  return amarillo;
                } else {
                  return verde;
                }
              }
            },
            type: 'bar',
            stack: 'x',
            label: {
              show: true,
              position: 'inside',
              formatter: function(params) {
                return 'Jueves' + ' ' + params.value + ' m3';
              }
            }
          },
          {
            data: [
              5899,
              {
                label: {
                  show: true,
                  position: 'inside',
                  formatter: totalAnterior + ' m3'
                }
              }
            ],
            itemStyle: {
              color: function(params) {
                if (params.data >= 8000) {
                  return rojo;
                } else if (params.data > 6000) {
                  return amarillo;
                } else {
                  return verde;
                }
              }
            },
            type: 'bar',
            stack: 'x',
            label: {
              show: true,
              position: 'inside',
              formatter: function(params) {

                return 'Viernes' + ' ' + params.value + ' m3';
              }
            }
          },
          {
            data: [
              3000,
              {
                label: {
                  show: true,
                  position: 'inside',
                  formatter: totalAnterior + ' m3'
                }
              }
            ],
            itemStyle: {
              color: function(params) {
                if (params.data >= 8000) {
                  return rojo;
                } else if (params.data > 6000) {
                  return amarillo;
                } else {
                  return verde;
                }
              }
            },
            type: 'bar',
            stack: 'x',
            label: {
              show: true,
              position: 'inside',
              formatter: function(params) {
                return 'Sabado' + ' ' + params.value + ' m3';
              }
            }
          },
          {
            data: [
              6500,
              {
                label: {
                  show: true,
                  position: 'inside',
                  formatter: totalAnterior + ' m3'
                }
              }
            ],
            itemStyle: {
              color: function(params) {
                if (params.data >= 8000) {
                  return rojo;
                } else if (params.data > 6000) {
                  return amarillo;
                } else {
                  return verde;
                }
              }
            },
            type: 'bar',
            stack: 'x',
            label: {
              show: true,
              position: 'inside',
              formatter: function(params) {

                return 'Domingo' + ' ' + params.value + ' m3';
              }
            }
          }
          // Rest of the series...
          
        ]

      };

      // Display the chart using the configuration items and data just specified.
      myChart.setOption(option);
    </script>
  </div>
</div>
@endsection