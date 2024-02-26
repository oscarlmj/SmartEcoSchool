@extends('layouts.chart')
@section('title', $viewData['title'])
@section('content')
    <div class="card">
        <div class="card-header">
            Consumo de agua mensual
            <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>

            <div id="main">
                <div id="clock"></div>
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
                    window.location.replace("http://localhost:8000/electrical");
                },  14000);
                
                let lastMonth = <?php echo json_encode($viewData['lastMonth']); ?>;
                let currentMonth = <?php echo json_encode($viewData['currentMonth']); ?>;

                let myChart = echarts.init(document.getElementById('week'));

                let lastMonthName = <?php echo json_encode($viewData['lastMonthName']); ?>;
                let currentMonthName = <?php echo json_encode($viewData['currentMonthName']); ?>;

                let rojo = '#FF4646';
                let naranja = '#FFA44F';
                let verde = '#67DF5F';


                // Specify the configuration items and data for the chart
                const gaugeData = [
                    {
                        value: lastMonth,
                        name: lastMonthName.charAt(0).toUpperCase() + lastMonthName.slice(1),
                        title: {
                            offsetCenter: ['0%', '-30%']
                        },
                        detail: {
                            valueAnimation: true,
                            offsetCenter: ['0%', '-20%'],
                            formatter: '{value}m3',
                        },
                            
                    },
                    {
                        value: (currentMonth * 100 / lastMonth).toFixed(2),
                        name: currentMonthName.charAt(0).toUpperCase() + currentMonthName.slice(1),
                        title: {
                            offsetCenter: ['0%', '0%']
                        },
                        detail: {
                            valueAnimation: true,
                            offsetCenter: ['0%', '10%',],
                            formatter: '{value}%'
                        },
                    },
                ];
                option = {
                    series: [
                        {
                            type: 'gauge',
                            startAngle: 90,
                            endAngle: -275,
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
                                    borderColor: '#464646'
                                }
                            },
                            axisLine: {
                                lineStyle: {
                                    width: 40
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
                                distance: 50
                            },
                            data: gaugeData,
                            title: {
                                fontSize: 14
                            },
                            detail: {
                                width: 85,
                                height: 14,
                                fontSize: 14,
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
