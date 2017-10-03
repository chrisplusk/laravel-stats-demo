@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <canvas id="chart" width="600" height="300"></canvas>

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
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>

    <script>
        (function() {
            var ctx = document.getElementById('chart').getContext('2d');
            var chart = {
                labels: {{ json_encode($labels) }},
                datasets: [{
                    data: {{ json_encode($values) }},
                    fillColor : "#f8b1aa",
                    strokeColor : "#bb574e",
                    pointColor : "#bb574e"
                }]
            };
            new Chart(ctx).Bar(chart, { bezierCurve: false });
        })();
    </script>
@stop