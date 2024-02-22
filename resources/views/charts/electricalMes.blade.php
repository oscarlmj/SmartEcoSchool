@extends('layouts.chart')
@section('title', $viewData["title"])
@section('content')
<div class="card">
    <div class="card-header">
        <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>

        <div id="main">
            <div id="month" style="width: 100%; height: 600px;"></div>
        </div>

        <script type="text/javascript">
            const chartDataAnterior = <?php echo json_encode($viewData["mesAnterior"]); ?>;
            const chartDataActual = <?php echo json_encode($viewData["mesActual"]); ?>;
            const chartNombreMesAnterior = <?php echo json_encode($viewData["nombreMesAnterior"]); ?>;
            const chartNombreMesActual = <?php echo json_encode($viewData["nombreMesActual"]); ?>;

            let option = {
                tooltip: {
                    trigger: 'item',

                },
                legend: {
                    top: '5%',
                    left: 'center'
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
                    data: [{
                            value: chartDataActual,
                            name: chartNombreMesActual
                        },
                        {
                            value: chartDataAnterior,
                            name: chartNombreMesAnterior,
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