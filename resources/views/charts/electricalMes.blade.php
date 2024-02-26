@extends('layouts.chart')
@section('title', $viewData["title"])
@section('content')
<div class="card">
    <div class="card-header">
        <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
        Consumo eléctrico mensual
        <div id="main">
        <div id="clock"></div>

            <div id="month" style="width: 100%; height: 600px;"></div>
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
                    window.location.replace("http://localhost:8000/water");
                },  14000);

            const chartDataActual = <?php echo json_encode($viewData["mesActual"]); ?>;
            const chartNombreMesAnterior = <?php echo json_encode($viewData["nombreMesAnterior"]); ?>;
            const chartNombreMesActual = <?php echo json_encode($viewData["nombreMesActual"]); ?>;
            const consumoMesesAnteriores = <?php echo json_encode($viewData['consumoMesesAnteriores']); ?>;
            const nombreMeses = <?php echo json_encode($viewData['monthNames']); ?>;


            let option = {
                tooltip: {
                    trigger: 'item',
                },
                legend: {
                    top: '5%',
                    left: 'center',
                },
                series: [{
                    type: 'pie',
                    radius: ['55%', '70%'],
                    avoidLabelOverlap: true,
                    padAngle: 100,
                    itemStyle: {
                        borderRadius: 5
                    },
                    label: {
                        show: true,
                        position: 'inside',
                        formatter: '{b}'
                    },
                    emphasis: {
                        label: {
                            show: true,
                            fontSize: 20,
                            fontWeight: 'bold'
                        }
                    },
                    labelLine: {
                        show: true,
                        length: 10,
                        length2: 5
                    },
                    data: [

                        {
                            value: 19500,
                            name: chartNombreMesActual,

                        },
                        {
                            value: consumoMesesAnteriores[0],
                            name: nombreMeses[0],
                        },
                        {
                            value: consumoMesesAnteriores[1],
                            name: nombreMeses[1],
                            
                        },
                        {
                            value: consumoMesesAnteriores[2],
                            name: nombreMeses[2],
                        },
                        {
                            value: consumoMesesAnteriores[3],
                            name: nombreMeses[3],
                        },
                        {
                            value: consumoMesesAnteriores[4],
                            name: nombreMeses[4],
                        },
                        {
                            value: consumoMesesAnteriores[5],
                            name: nombreMeses[5],
                        },
                        {
                            value: consumoMesesAnteriores[6],
                            name: nombreMeses[6],
                        },
                        {
                            value: consumoMesesAnteriores[7],
                            name: nombreMeses[7],
                        },
                        {
                            value: consumoMesesAnteriores[8],
                            name: nombreMeses[8],
                        },
                        {
                            value: consumoMesesAnteriores[9],
                            name: nombreMeses[9],
                        },
                        {
                            value: consumoMesesAnteriores[10],
                            name: nombreMeses[10],
                        }
                    ]
                }]
            };

            const myChart = echarts.init(document.getElementById('month'));

            // Display the chart using the configuration items and data just specified.
            myChart.setOption(option);
            
        </script>
    </div>
</div>
@endsection