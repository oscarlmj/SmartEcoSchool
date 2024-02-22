@extends('layouts.chart')
@section('title', $viewData['title'])
@section('content')
    <div class="card">
        <div class="card-header">
            Consumo de agua mensual
            <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>

            <div id="main">
                <div id="week" style="width: 100%; height: 600px;"></div>
            </div>


            <script type="text/javascript">
                let lastMonth = <?php echo json_encode($viewData['lastMonth']); ?>;
                let currentMonth = <?php echo json_encode($viewData['currentMonth']); ?>;
                let myChart = echarts.init(document.getElementById('week'));
                let lastMonthName = <?php echo json_encode($viewData['lastMonthName']); ?>;
                let currentMonthName = <?php echo json_encode($viewData['currentMonthName']); ?>;
                let rojo = '#FF4646';
                let naranja = '#FFA44F';
                let verde = '#67DF5F';


                // Specify the configuration items and data for the chart
                option = {
                    xAxis: {
                        type: 'category',
                        data: [lastMonthName.toUpperCase(),currentMonthName.toUpperCase()]
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            data: [
                                {
                                    value: lastMonth,
                                    itemStyle: {
                                        color: 'skyblue'
                                    }
                                },
                                {
                                    value: currentMonth,
                                    itemStyle: {
                                        color: '#67DF5F'
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
