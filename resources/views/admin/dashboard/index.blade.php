@extends('layouts.app')

@push('head-script')
<style>
    .ml{
        margin-left: 130px;
    }
 





  
</style>
    <link rel="stylesheet" href="{{ asset('assets/plugins/jQueryUI/jquery-ui.min.css') }}">
@endpush

@section('content')
    <div class="row d-flex">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="chart-title">
                        <h3 style="text-align:center;">Branch Wise Purchases</h3>
                    </div>
                    
                    <div class="flex-grow-1 d-flex justify-content-center align-items-center">
                        <canvas id="branchPurchase_chart" style="width: 100px; height: 80px;" resize="true" ></canvas>
                    </div>

                    <div id="chart-legends"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="chart-title">
                        <h3 style="text-align:center;">Item Wise Points</h3>
                        <div class="row">
    {{-- <div class="col-md-6">
        <label for="branchSelect">Select Branch:</label> 
        <select class="form-control" id="branchSelect" onchange="updatePointChart()" name="branchSelect">
            <option>All</option>
            @foreach ($branch as $data)
                <option value="{{$data->id}}">{{$data->name}}</option>
            @endforeach
        </select>
    </div> --}}
    {{-- <div class="col-md-4 col-sm-12">
    <label for="totalPoints">Total Points:</label>
    <input type="text" style="width:85px;"class="form-control" id="totalPoints" value="{{ $branchPoint['totalPointsSum'] }}" readonly>
    
</div> --}}
</div>
                  
                    </div>
                    <br>
                    <canvas id="branchPoint_chart" style="width: 100px; height: 62px;" resize="true"></canvas>
                </div>
            </div>
        </div>
    </div>
    <br>
    {{-- @if($viewLogs)
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="chart-title">
                        <h4>Log</h4>
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>@lang('app.updatelogs.created')</th>
                                    <th>@lang('app.user.branch')</th>
                                    <th>@lang('app.updatelogs.data')</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif --}}
@endsection

@push('footer-script')
    <script src="{{ asset('assets/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/Chart.js/Chart.bundle.js') }}"></script>
    {{-- <script>
        //this is to calculate the total purchase for graph
        var purchase = {!! $branchPurchase['purchase'] !!};
        var sum_purchase = 0;

        for (var i = 0; i < purchase.length; i++) {
            sum_purchase += parseInt(purchase[i], 10);
        }
        

        //this is to calculate total points for graph
        
        var point = {!! $branchPoint['totalpoints'] !!};
        var sum_point = 0;
        for (var i = 0; i < point.length; i++) {
            sum_point += parseInt(point[i], 10);
        }
        $(document).ready(function() {
            if ('{{ $viewLogs }}' == 1) {
                var table = $('#myTable').dataTable({
                    responsive: true,
                    scrollX: true,
                    // processing: true,
                    serverSide: true,
                    pageLength: 5,
                    order: [[1, 'desc']],
                    ajax: '{!! route('admin.dashboarddata') !!}',
                    language: languageOptions(),
                    "fnDrawCallback": function(oSettings) {
                        $("body").tooltip({
                            selector: '[data-toggle="tooltip"]'
                        });
                    },

                    columns: [{
                            data: 'DT_Row_Index'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'data',
                            name: 'data'
                        
                        }
                    ],
                });
            }


          branchPurchaseChart({!! $branchPurchase['branch'] !!}, {!! $branchPurchase['purchase'] !!});
            branchPointChart({!! $branchPoint['categories'] !!}, {!! $branchPoint['totalpoints'] !!});
        });

       // Purchase
    function branchPurchaseChart(chartData, chartData1) {
        var ctx = document.getElementById('branchPurchase_chart').getContext('2d');

        var datasets = [];
        var backgroundColors = ['#DEB887', '#A9A9A9', '#DC143C', '#F4A460', '#2E8B57'];

        for (var i = 0; i < chartData.length; i++) {
            var datasetObject = {
                label: chartData[i],
                data: [chartData1[i]],
                backgroundColor: backgroundColors[i % backgroundColors.length]
            };
            datasets.push(datasetObject);
        }

        var data = {
            labels: ['Branches'], //chartData,
            datasets: datasets
        };

        var options = {
            responsive: true,
            legend: {
                display: false,
                position: "bottom",
                labels: {
                    fontColor: "#333",
                    fontSize: 12,
                }
            },
            legendCallback: function(chart) {
                var text = [];
                for (var i=0; i<chart.data.datasets.length; i++) {
                    console.log(chart.data.datasets[i]);
                    text.push('<span style="background-color:' + chart.data.datasets[i].backgroundColor + '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;<span>' + chart.data.datasets[i].label + '</span>');
                    text.push('</br>');
                }
                return text.join("");
            },          
            scales: {
                yAxes: [{
                    ticks: {
                        min: 0,
                        max: sum_purchase + 100,
                        stepSize: 1000,
                        beginAtZero: true,
                    }
                }]
            }
   
        };

        var chart1 = new Chart(ctx, {
            type: "bar",
            data: data,
            options: options
        });

        document.getElementById('chart-legends').innerHTML = chart1.generateLegend();

    }

        //Point
        function branchPointChart(chartData, chartData1) {
            var ctx = document.getElementById('branchPoint_chart').getContext('2d');
            
            var dataset = [];

            var datasetColor = [];

            var j = 0;

            var datasetObject = new Object();

            datasetObject.data = chartData1;

            for (var i = 0; i < chartData.length; i++) {
                j = i;

                if (j == 0) {
                    datasetColor.push('#DEB887');
                } else if (j == 1) {
                    datasetColor.push('#A9A9A9');
                } else if (j == 2) {
                    datasetColor.push('#DC143C');
                } else if (j == 3) {
                    datasetColor.push('#F4A460');
                } else if (j == 4) {
                    datasetColor.push('#2E8B57');

                    j = 0;
                }
            }

            j = 0;

            datasetObject.backgroundColor = datasetColor;

            dataset.push(datasetObject);

            var data = {
                labels: chartData, //["Mobile", "Accessories", "Maintenance", "Other", "Refer"], // Static labels
                datasets: dataset,
            };
            

            var options = {
                responsive: true,
                
                legend: {
                    display: false,
                    position: "bottom",
                    labels: {
                        fontColor: "#333",
                        fontSize: 12,
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: sum_point + 50000,
                            stepSize: 100000,
                            beginAtZero: true,
                        }
                    }]
                }
            };

            // Update existing chart or create new chart
            if (window.chart1) {
                chart1.data.labels = data.labels;
                chart1.data.datasets = data.datasets;
                chart1.update();
            } else {
                window.chart1 = new Chart(ctx, {
                    type: "bar",
                    data: data,
                    options: options
                });
            }      
        }

      
        function updatePointChart() {
            var selectedBranchId = document.getElementById('branchSelect').value;
      
            console.log("Selected Branch ID:", selectedBranchId); 
        
            $.ajax({
                url: '{!! url("/") !!}' + '/admin/getPointsData',
                type: 'GET',
                data: {
                    branch_id: selectedBranchId
                },
                success: function(response) {
                    
                    console.log("Points Data Response:", response); 
         
 // Update totalPoints input field
 $('#totalPoints').val(response.totalPointsSum);
          // branchPointChart(["Mobile", "Accessories", "Maintenance", "Other", "Refer"], JSON.parse(response.totalpoints));
                    branchPointChart(JSON.parse(response.categories), JSON.parse(response.totalpoints));

        },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

    </script> --}}
@endpush
