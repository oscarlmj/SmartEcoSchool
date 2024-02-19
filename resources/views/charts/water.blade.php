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
      let totalAnterior = <?php echo json_encode($viewData["semanaAnterior"]); ?>;
      let myChart = echarts.init(document.getElementById('week'));
      
      
      let week = <?php echo json_encode($viewData["week"]); ?>;
      
      let rojo = '#FF4646';
      let naranja = '#FFA44F';
      let verde = '#67DF5F';

      // Specify the configuration items and data for the chart
      let option = {
        
        xAxis: {
          data: ['SEMANA ACTUAL', 'SEMANA ANTERIOR']
        },
        yAxis: {},
        series: [{
            data: [
              week[0],
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
                  return naranja;
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
              week[1],
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
                  return naranja;
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
              week[2],
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
                  return naranja;
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
              week[3],
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
                  return naranja;
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
              week[4],
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
                  return naranja;
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
              week[5],
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
                  return naranja;
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
              week[6],
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
                  return naranja;
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