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
                    
                    <div id="filter" style="display: none;">
                        
                    </div>
                    <div class="row">
                        <button id="filterbutton" style="width: 100%;">Filter</button>
                    </div>
                
                    <div class="row">
                        <div class="col-md-3">
                            
                            <canvas id="doughnut_chart" style="float: left;" width="300" height="150"></canvas>

                        </div>
                        <div class="col-md-6">

                            <canvas id="line_chart" style="float: left;" width="500" height="300"></canvas>
                        
                        </div>
                        <div class="col-md-3">

                            <canvas id="bar_chart" style="float: right;" width="300" height="150"></canvas>
                            
                        </div>
                    </div>
                    
                    <div id="seedbutton" class="row">
                        <button style="width: 100%;">Seed</button>
                    </div>
                    
                    <div id="stats" class="row">
                    
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
            
            $.ajax({
                url: "home/filter"
            }).done(function( data ) {
                $('#filter').html(data);
            });
            
            table_ajax = function ()
            {
                $.ajax({
                    url: "home/table"
                }).done(function( data ) {
                    $('#stats').html(data);
                });
            }
            
            var doughnut_ctx    = $('#doughnut_chart')[0].getContext('2d');
            var line_ctx        = $('#line_chart')[0].getContext('2d');
            var bar_ctx         = $('#bar_chart')[0].getContext('2d');
            
            doughnut_ajax = function() {
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
            }
            
            line_ajax = function() {
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
            }
            
            bar_ajax = function() {
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
            }
        
            $('#filterbutton').click(function() {
                $('#filterbutton').html( $('#filter').is(':visible') ? 'Filter' : 'Apply' );
                
                if ($('#filter').is(':visible'))
                {
                    //$('#filter_form').submit();
                    $.ajax({
                       type: "POST",
                       url: $('#filter_form').attr('action'),
                       data: $("#filter_form").serialize(), // serializes the form's elements.
                       success: function(data)
                       {
                           //alert(data); // show response from the php script.
                       }
                     });
                    
                    setTimeout(table_ajax, 500);
                    setTimeout(doughnut_ajax, 500);
                    setTimeout(line_ajax, 500);
                    setTimeout(bar_ajax, 500);
                }
                
                $('#filter').slideToggle();
            });
            
            table_ajax();
            doughnut_ajax();
            line_ajax();
            bar_ajax();
            
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