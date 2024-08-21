@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
@endpush



@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                  <div class="m-4">
                  <div class="row align-items-center my-3">
    <div class="col-md-2" style="flex: 0 0 16.666667%; max-width: 15.666667%;">
        <div class="form-group mb-0" style="width: 100%;">
            <label for="Categories" class="mb-0">Gift Categories:</label>
            <select class="form-control select" id="category" name="categories">
                <option value="">Select All</option>
                @foreach ($categories as $data)
                    <option value="{{ $data->gift_category_name }}">{{ $data->gift_category_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-2" style="flex: 0 0 16.666667%; max-width: 14.666667%;">
        <div class="form-group mb-0" style="width: 100%;">
            <label for="Branch" class="mb-0">Branche Name:</label>
            <select class="form-control select" id="branch" name="branch_id">
                <option value="">Select All</option>
                @foreach ($branches as $data)
                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-2" style="flex: 0 0 16.666667%; max-width: 13.666667%;">
        <div class="form-group mb-0" style="width: 100%;">
            <label for="User" class="mb-0">User Name:</label>
            <select class="form-control select" id="user" name="user_id">
                <option value="">Select All</option>
                @foreach ($users as $data)
                    <option value="{{ $data->mobile }}">{{ $data->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-2" style="flex: 0 0 16.666667%; max-width: 13.666667%;">
        <div class="form-group mb-0" style="width: 100%;">
            <label for="fromDate" class="mb-0">From Date:</label>
            <input type="date" class="form-control" id="fromDate" name="from_date">
        </div>
    </div>

    <div class="col-md-2" style="flex: 0 0 16.666667%; max-width: 13.666667%;">
        <div class="form-group mb-0" style="width: 100%;">
            <label for="toDate" class="mb-0">To Date:</label>
            <input type="date" class="form-control" id="toDate" name="to_date">
        </div>
    </div>

    <div class="col-md-2" style="flex: 0 0 16.666667%; max-width: 10.666667%;">
        <div class="form-group mb-0" style="width: 100%;">
            <label for="fromPoint" class="mb-0">From Point:</label>
            <input type="number" class="form-control" id="fromPoint" name="from_point">
        </div>
    </div>

    <div class="col-md-2" style="flex: 0 0 16.666667%; max-width: 10.666667%;">
        <div class="form-group mb-0" style="width: 100%;">
            <label for="toPoint" class="mb-0">To Point:</label>
            <input type="number" class="form-control" id="toPoint" name="to_point">
        </div>
    </div>

    <div class="col-md-1" style="flex: 0 0 8.333333%; max-width: 7.333333%;">
        <button type="button" id="filterButton" class="btn btn-success waves-effect waves-light m-r-10 mt-4">Filter</button>
    </div>
</div>


                </div>

                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    
                                    <th>S.No</th>
                                    <th>@lang('app.userwisereports.user')</th>
                                    <th>@lang('app.userwisereports.categories')</th>
                                    <th>@lang('app.userwisereports.branch')</th>
                                    <th>@lang('app.userwisereports.created')</th>
                                  
                                    <th>@lang('app.userwisereports.points')</th>
                                    <!-- <th>@lang('app.userwisereports.desc')</th> -->
                                    <!-- <th class="noExport">@lang('app.action')</th> -->
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-script')
    <script src="//cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script src="{{ asset('assets/plugins/select2/select2.js') }}"></script>
    <script>
        var groupColumn = 1;
        var sumColumn = 5;

        var table = $('#myTable').dataTable({
            responsive: true,
            // processing: true,
            serverSide: true,
         
          
            pageLength: 100,
    lengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, 'All']
    ],
            ajax: '{!! route('admin.user-reports.data') !!}',
            language: languageOptions(),
            "fnDrawCallback": function(oSettings) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
                
            },
            
            
            // "columnDefs": [
            //     {
            //         "visible": false,
            //         "targets": groupColumn
            //     }
            // ],


            "order": [
                [
                    groupColumn, 'asc'
                ]
            ],
         
            "fnDrawCallback": function(oSettings) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });

                //Group
                var api = this.api();
                var rows = api.rows({page:'current'}).nodes();
                var last = null;
                var aData = new Array();
                
                api.column(groupColumn, {page:'current'} ).data().each(function (group, i) {
                    var totalPoints = api.column(sumColumn).data()[i];

                    if (typeof aData[group] == 'undefined') {
                        aData[group] = new Array();
                        aData[group].rows = [];
                        aData[group].total_points = [];
                    }

                    aData[group].rows.push(i); 
                    aData[group].total_points.push(totalPoints); 
                });

                var idx = 0;

                for(var groupData in aData) {
                    idx = Math.max.apply(Math, aData[groupData].rows);
        
                    var groupSum = 0;

                    $.each(aData[groupData].total_points, function (k, v){
                        groupSum += parseFloat(v);
                    });

                    $(rows).eq( idx ).after(
                        // '<tr style="background-color:#e5f3ff;">' +
                        // '<td colspan="4" style="text-align:center;font-weight:bold;">Total</td>' +
                        // '<td colspan="3" style="font-weight:bold;">' + groupSum + '</td>' +
                        // '</tr>'
                    );
                }
            },
            columns: [
                {
                    //data: 'id',
                    name: 'id',
                    width:'5%',
                    orderable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }
                    // render: function(data, type, row) {
                    //     if (type === 'display') {
                    //         var baseUrl = "{{ url('/') }}"; 
                    //         return '<a href="' + baseUrl + '/admin/user/' + row['user_id'] + '/edit">'  + data + '</a>';
                    //         // return '<a href="/admin/gifts/' + data + '/edit">'  + data + '</a>';
                    //     }
                    //     return data;
                    // }
                 
                },
                {
                    data: 'name', 
                    name: 'name',
                    width:'15%',
                },
                {
        data: 'categories',
        name: 'categories',
        orderable: false,
        width:'15%',
        render: function(data, type, row) {
        var selectedCategory = $('#category').val();
        if (selectedCategory === 'Select All' || row['categories'] === selectedCategory) {
            return data;
        }
        return 'All Categories';
    }
    },
    {
        data: 'branch',
        name: 'branch',
        orderable: false,
        width: '16%',
        render: function(data, type, row) {
            var selectedBranch = $('#branch').val();
            if (selectedBranch === 'Select All' || row['branch_id'] == selectedBranch) {
                return data;
            }
            return 'All Branches';
        }
    },
                {
                    data: 'created',
                    name: 'created',
                    orderable: false,
                      width:'15%'
                },
//                 {
//     data: 'date_range',
//     name: 'date_range',
//     width: '15%'
// },
                
                {
        data: 'points',
        name: 'points',
        
        width:'5%',
        
      
    },
                
                // {
                //     data: 'action',
                //     name: 'action',
                //       width:'5%'
                // }
            ],


            
            "dom": 'lBfrtip', //'Bfrtip' -> If buttons not required remove dom
            "buttons": [
                {
                    extend: 'excel',
                    className: 'btn btn-primary',
                    title: '{{ $pageTitle }}',
                    exportOptions: {
                        
                        columns: "thead th:not(.noExport)"
                    }
                    
                },




                {
                    extend: 'pdf',
                    className: 'btn btn-primary',
                    title: '{{ $pageTitle }}',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },
                {

                    extend: 'print',
                    className: 'btn btn-primary',
                    title: '{{ $pageTitle }}',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },
  
            ]
            
        });

        new $.fn.dataTable.FixedHeader(table);

        $('#filterButton').on('click', function() {
            var categoryId = $('#category').val();
            var userId = $('#user').val();
            var branchId = $('#branch').val();
            var fromDate = $('#fromDate').val();
            var toDate = $('#toDate').val();
            var fromPoint = $('#fromPoint').val();
    var toPoint = $('#toPoint').val();
            var url = '{!! route('admin.user-reports.data') !!}?';

            if (branchId != '') {
                url += 'branch_id=' + branchId + '&';
            }


            if (userId != '') {
                url += 'user_id=' + userId + '&';
            }

            if (fromDate != '') {
                url += 'from_date=' + fromDate + '&';
            }

            if (toDate != '') {
                url += 'to_date=' + toDate + '&';
            }
            if (categoryId!= '') {
                url += 'categories=' + categoryId + '&';
            }
        

    if (fromPoint != '') {
        url += '&from_point=' + fromPoint;
    }

    if (toPoint != '') {
        url += '&to_point=' + toPoint;
    }
    
            console.log(url);

            table.api().ajax.url(url).load(function() {
                if (table.fnSettings().fnRecordsTotal() === 0) {
            alert('No data available.');
        }
                // Recalculate and display the total only when the table data is reloaded
                calculateAndDisplayTotal();
            });
        });


 function calculateAndDisplayTotal() {
    var api = table.api();
    var rows = api.rows({ page: 'current' }).nodes();
    var last = null;
    var userData = {};

    // Iterate over each row in the current page of the table
    api.rows({ page: 'current' }).every(function() {
        var data = this.data();
        var userId = data.user_id;

        // Initialize total points for the user if not already done
        if (!(userId in userData)) {
            userData[userId] = {
                totalPoints: 0,
                rowIdx: -1
            };
        }

        // Accumulate total points for the user
        userData[userId].totalPoints += parseFloat(data.points);

        // Store the index of the last row for this user
        userData[userId].rowIdx = this.index();
    });

    // Display total points for each user in a single row
    for (var userId in userData) {
        var totalPoints = userData[userId].totalPoints;
        var rowIdx = userData[userId].rowIdx;

        if (rowIdx >= 0) {
            // Update points column with total points for this user
            $(rows[rowIdx]).find('td:eq(5)').text(totalPoints);
        }
    }
}

        $('body').on('click', '.sa-params', function() {
            var id = $(this).data('row-id');
            swal({
                title: "@lang('app.messages.areYouSure')",
                text: "@lang('app.messages.deleteWarning')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('app.delete')",
                cancelButtonText: "@lang('app.cancel')",
                closeOnConfirm: true,
                closeOnCancel: true

            }, function(isConfirm) {

                if (isConfirm) {

                    var url = "{{ route('admin.gifts.destroy', ':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({

                        type: 'POST',
                        url: url,
                        data: {
                            '_token': token,
                            '_method': 'DELETE'
                        },
                        success: function(response) {
                            if (response.status == "success") {
                                $.unblockUI();

                                //swal("Deleted!", response.message, "success");
                                table._fnDraw();
                            }
                        }
                    });
                }
            });
        });


        $('body').on('change', '.role_id', function() {
            var id = $(this).val();
            var userId = $(this).data('row-id');
            var url = '{{ route('admin.user.changeRole') }}';

            $.easyAjax({
                url: url,
                type: 'POST',
                data: {
                    roleId: id,
                    userId: userId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status == "success") {
                        $.unblockUI();

                        //swal("Deleted!", response.message, "success");

                        table._fnDraw();
                    }

                }
            })
        });
        $('#user').select2({
            matcher: function(params, data) {
                if ($.trim(params.term) === "") {
                    return data;
                }
                if (typeof data.text === "undefined") {
                    return null;
                }
                var q = params.term.toLowerCase();
                if (data.text.toLowerCase().indexOf(q) > -1 || data.id.toLowerCase().indexOf(q) > -1)
                {
                    return $.extend({}, data, true);
                }
                return null;
            },
            placeholder: "Select All",
        });
        

    </script>
@endpush
