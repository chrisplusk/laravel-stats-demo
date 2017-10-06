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
                    
                    <div class="row">
                        <div class="col">
                            
                            <canvas id="doughnut_chart" style="float: left;" width="300" height="150"></canvas>

                        </div>
                        <div class="col">

                            <canvas id="line_chart" style="float: left;" width="500" height="300"></canvas>
                        
                        </div>
                        <div class="col">

                            <canvas id="bar_chart" style="float: right;" width="300" height="150"></canvas>
                            
                        </div>
                    </div>
                    
                    <div class="row justify-content-center">
                        <div class="col">
                        
                            <button id="seed">Seed</button>
                            
                        </div>
                    </div>
                    
                    <div class="row">
                    
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr><th>Date</th><th>Category</th><th>Client</th><th>Label</th><th>Value</th></tr>
                            </thead>
                            <tbody>
                            <?php foreach($stats as $row) { ?>
                                <tr><td>{{ $row->date }}</td><td>{{ $row->category_id }}</td><td>{{ $row->client_id }}</td><td>{{ $row->label_id }}</td><td>{{ $row->value }}</td></tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    
                    </div>
                    
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
            
            var doughnut_ctx    = $('#doughnut_chart')[0].getContext('2d');
            var line_ctx        = $('#line_chart')[0].getContext('2d');
            var bar_ctx         = $('#bar_chart')[0].getContext('2d');
            
            $.ajax({
                url: "home/doughnut"
            }).done(function( data ) {
                
                var doughnutChart = new Chart(doughnut_ctx, {
                    type: 'doughnut',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: data.values,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.5)',
                                'rgba(54, 162, 235, 0.5)',
                                'rgba(255, 206, 86, 0.5)',
                                'rgba(75, 192, 192, 0.5)',
                                'rgba(153, 102, 255, 0.5)',
                                'rgba(255, 159, 64, 0.5)'
                            ],
                            borderColor: 'rgba(75, 192, 192, 0.5)',
                            fill: false,
                            pointBackgroundColor: 'rgba(75, 192, 192, 0.5)'
                        }]
                    },
                    options: {
                        legend: { display: false, },
                        title: { display: false, },
                        responsive: false,
                    }
                });
                
            });
            
            $.ajax({
                url: "home/line"
            }).done(function( data ) {
                
                var lineChart = new Chart(line_ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: data.values,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.5)',
                                'rgba(54, 162, 235, 0.5)',
                                'rgba(255, 206, 86, 0.5)',
                                'rgba(75, 192, 192, 0.5)',
                                'rgba(153, 102, 255, 0.5)',
                                'rgba(255, 159, 64, 0.5)'
                            ],
                            borderColor: 'rgba(75, 192, 192, 0.5)',
                            fill: false,
                            pointBackgroundColor: 'rgba(75, 192, 192, 0.5)'
                        }]
                    },
                    options: {
                        legend: { display: false, },
                        title: { display: false, },
                        responsive: false,
                        scales: {
                            xAxes: [{
                                        gridLines: {
                                            display:false
                                        }
                                    }],
                            yAxes: [{
                                        gridLines: {
                                            display:true
                                        }   
                                    }]
                        }
                    }
                });
                
            });
            
            $.ajax({
                url: "home/bar"
            }).done(function( data ) {
                
                var barChart = new Chart(bar_ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: data.values,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.5)',
                                'rgba(54, 162, 235, 0.5)',
                                'rgba(255, 206, 86, 0.5)',
                                'rgba(75, 192, 192, 0.5)',
                                'rgba(153, 102, 255, 0.5)',
                                'rgba(255, 159, 64, 0.5)'
                            ],
                            borderColor: 'rgba(75, 192, 192, 0.5)',
                            fill: false,
                            pointBackgroundColor: 'rgba(75, 192, 192, 0.5)'
                        }]
                    },
                    options: {
                        legend: { display: false, },
                        title: { display: false, },
                        responsive: false,
                        scales: {
                            xAxes: [{
                                display: false
                              }],
                              yAxes: [{
                                display: false
                              }],
                        }
                    }
                });
                
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