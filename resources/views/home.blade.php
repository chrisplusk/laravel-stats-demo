@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <canvas id="doughnut_chart" style="float: left;" width="300" height="150"></canvas>

                    <canvas id="line_chart" style="float: left;" width="500" height="300"></canvas>

                    <canvas id="bar_chart" style="float: right;" width="300" height="150"></canvas>
                    
                    <button id="seed">Seed</button>

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr><th>Date</th><th>Value</th></tr>
                        </thead>
                        <tbody>
                        <?php foreach($stats as $row) { ?>
                            <tr><td>{{ $row->date }}</td><td>{{ $row->value }}</td></tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>

    <script>

        $( document ).ready(function() {
            
            var barChartData = {
                labels: {{ json_encode($labels) }},
                datasets: [{
                    data: {{ json_encode($values) }},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: 'rgba(75, 192, 192, 0.5)',
                    fill: false,
                    pointBackgroundColor: 'rgba(75, 192, 192, 0.5)'
                }]
            };

            var doughnut_ctx    = $('#doughnut_chart')[0].getContext('2d');
            var line_ctx        = $('#line_chart')[0].getContext('2d');
            var bar_ctx         = $('#bar_chart')[0].getContext('2d');
            
            var doughnutChart = new Chart(doughnut_ctx, {
                type: 'doughnut',
                data: barChartData,
                options: {
                    legend: { display: false, },
                    title: { display: false, },
                    responsive: false,
                }
            });
        
            var lineChart = new Chart(line_ctx, {
                type: 'line',
                data: barChartData,
                options: {
                    legend: { display: false, },
                    title: { display: false, },
                    responsive: false,
                }
            });
        
            var barChart = new Chart(bar_ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    legend: { display: false, },
                    title: { display: false, },
                    responsive: false,
                }
            });
        
            $('#seed').click(function () {
                barChartData.labels.shift();
                barChartData.datasets[0].data.shift();
                
                barChartData.labels.push('#');
                barChartData.datasets[0].data.push( Math.round(Math.random() * 1000) );
                
                doughnutChart.update();
                lineChart.update();
                barChart.update();
            });
            
        });
        
    </script>
@stop