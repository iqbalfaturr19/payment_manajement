@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">🏆 Employees with the Highest Bonuses</h3>
                        </div>
                        <div class="panel-body">
                            @if($highestEmployee)
                                {{$highestEmployee->employee->name}}
                            @else
                                No data available
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">🔻 Employees with the Lowest Bonuses</h3>
                        </div>
                        <div class="panel-body">
                            @if($lowestEmployee)
                                {{$lowestEmployee->employee->name}}
                            @else
                                No data available
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">👥 Number of Employees Get Bonuses</h3>
                        </div>
                        <div class="panel-body">
                            {{$total_employees}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <canvas id="ChartBonuses" style="width:100%;max-width:700px"></canvas>
                </div>
                
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">📊 Total Bonus Distributed</h3>
                        </div>
                        <div class="panel-body">
                            {{ 'Rp ' . number_format($totalNominal, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scriptText')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script>
    var xValues = {!! $xValues !!};
    var yValues = {!! $yValues !!};
    var barColors = ["red", "green", "blue", "orange", "brown"];

    new Chart("ChartBonuses", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
            backgroundColor: barColors,
            data: yValues
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) {
                            if (value === 0) {
                                return "0";
                            }
                            return value.toLocaleString();
                        }
                    }
                }]
            },
            legend: {display: false},
            title: {
                display: true,
                text: "Total Monthly Bonus"
            }
        }
    });
</script>
@endsection
