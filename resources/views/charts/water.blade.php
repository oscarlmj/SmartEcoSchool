@extends('layouts.chart')
@section('title', $viewData['title'])
@section('content')
    <div class="card">
        <div class="card-header">
            Consumo de agua
            <div id="clock"></div>

            <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>

            <div id="main">
                <div id="week" style="width: 100%; height: 600px;"></div>
            </div>

            <script type="text/javascript">
                setInterval(function() {
                    let momentoActual = new Date();
                    let fecha = momentoActual.toLocaleDateString();
                    let hora = momentoActual.getHours();
                    let minuto = String(momentoActual.getMinutes()).padStart(2, '0');
                    let segundo = String(momentoActual.getSeconds()).padStart(2, '0');
                    let horaActual = hora + ":" + minuto + ":" + segundo;
                    let fechaHoraActual = fecha + " " + horaActual;
                    document.getElementById('clock').innerHTML = fechaHoraActual;
                }, 1000);


                setInterval(function() {
                    window.location.replace("http://localhost:8000/watermonth");
                },  10000);

                let totalAnterior = <?php echo json_encode($viewData['semanaAnterior']); ?>;
                let consumoActual = <?php echo json_encode($viewData['consumoActual']); ?>;
                let consumosAnteriores = <?php echo json_encode($viewData['consumoSemanal']); ?>;
                let myChart = echarts.init(document.getElementById('week'));

                let rojo = '#FF4646';
                let naranja = '#FFA44F';
                let verde = '#67DF5F';

                option = {
                    xAxis: {
                        type: 'category',
                        data: <?php echo json_encode(array_map(function($value) {
                            return 'semana ' . $value;
                        }, $viewData['weekNumbers'])); ?>
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
                                    value: totalAnterior,
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
                myChart.setOption(option);
            </script>
        </div>
    </div>
@endsection
