@extends('layouts.chart')
@section('title', $viewData['title'])
@section('content')
    <div class="card">
        <div class="card-header">
            Consumo de agua
            <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>

            <div id="main">
                <div id="week" style="width: 100%; height: 600px;"></div>
            </div>


            <script type="text/javascript">
                let totalAnterior = <?php echo json_encode($viewData['semanaAnterior']); ?>;
                let consumoSemanal = <?php echo json_encode($viewData['consumoSemanal']); ?>;
                let myChart = echarts.init(document.getElementById('week'));


                let rojo = '#FF4646';
                let naranja = '#FFA44F';
                let verde = '#67DF5F';


                // Specify the configuration items and data for the chart
                option = {
                    xAxis: {
                        type: 'category',
                        data: ['Semana actual', 'Semana anterior']
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            data: [
                                {
                                    value: consumoSemanal,
                                    itemStyle: {
                                        color: '#67DF5F'
                                    }
                                },
                                {
                                    value: totalAnterior,
                                    itemStyle: {
                                        color: 'skyblue'
                                    }
                                }
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

                // Display the chart using the configuration items and data just specified.
                myChart.setOption(option);
            </script>
        </div>
    </div>
@endsection
