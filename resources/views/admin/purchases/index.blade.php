@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="m-4">
                    <div class="row align-items-center my-3">
                        <div class="col-md-2">
                            <!-- Branch dropdown field -->
                            <div class="form-group mb-0">
                                <label for="Branch" class="mb-0">Branch Name:</label>
                                <select class="form-control select" id="branch" name="branch_id">
                                    <option value="">Select All</option>
                                    @foreach ($branch as $data)
                                        
                                        <option value="{{ $data->id }}"> {{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <!-- User dropdown field -->
                            <div class="form-group mb-0">
                                <label for="User" class="mb-0">User Type:</label>
                                <select class="form-control select" id="user" name="user_id">
                                       <option value="">Select All</option>
                                    @foreach ($users as $data)
                                     
                                        <option value="{{ $data->mobile }}"> {{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="col-md-2">
                            <!-- From date field -->
                            <div class="form-group mb-0">
                                <label for="fromDate" class="mb-0">From Date:</label>
                                <input type="date" class="form-control" id="fromDate" name="from_date">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <!-- To date field -->
                            <div class="form-group mb-0">
                                <label for="toDate" class="mb-0">To Date:</label>
                                <input type="date" class="form-control" id="toDate" name="to_date">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button type="button" id="filterButton"
                                class="btn btn-success waves-effect waves-light m-r-10 mt-4">Filter</button>

                        </div>
                    </div>
                </div>


                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>@lang('app.purchases.user_id')</th>
                                    <th>@lang('app.purchases.points')</th>
                                    <th>@lang('app.purchases.date')</th>
                                    <th>@lang('app.purchases.bill_no')</th>
                                    <th>@lang('app.purchaseitem.itemname')</th>
                                    <th>@lang('app.user.branch')</th>
                                    <th>@lang('app.purchaseitem.quantity')</th>
                                    <th>@lang('app.purchases.total')</th>
                                    <th class="noExport">@lang('app.action')</th>
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

       
        var table = $('#myTable').dataTable({
            responsive: true,
            serverSide: true,
            ajax: '{!! route('admin.purchases.data') !!}',
            pageLength: 100,
            order: [[3, 'desc']],
            language: languageOptions(),
            "fnDrawCallback": function(oSettings) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            },
            columns: [{
                        data: 'id',
                        name: 'id',
                        width:'5%',
                        render: function(data, type, row) {
                            if (type === 'display') {
                                var baseUrl = "{{ url('/') }}"; 
                                return '<a href="' + baseUrl + '/admin/user/' + row['user_id'] + '/edit">'  + data + '</a>';
                            }
                            return data;
                        }
                      
                    },
                {
                    data: 'user_name',
                    name: 'user_name',
                    width:'15%'
                },
                {
                    data: 'points',
                    name: 'points',
                    width:'5%'
                },
                {
                    data: 'date',
                    name: 'date',
                    width:'15%'
                },
                {
                    data: 'bill_no',
                    name: 'bill_no',
                    width:'7%'
                },
                {
                    data: 'item_name',
                    name: 'item_name',
                    width:'13%'
                },
                {
                    data: 'branch_name',
                    name: 'branch_name',
                    width:'22%'
                },
                {
                    data: 'quantity',
                    name: 'quantity',
                    width:'1%'
                },
                {
                    data: 'total',
                    name: 'total',
                    width:'11%'
                },
                {
                    data: 'action',
                    name: 'action',
                    width:'6%'
                }
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
            var userId = $('#user').val();

            var branchId = $('#branch').val();
            var fromDate = $('#fromDate').val();
            var toDate = $('#toDate').val();
            var url = '{!! route('admin.purchases.data')  !!}?';

          if(branchId != ''){
                url += 'branch_id=' + branchId + '&';
            }

            if(userId != ''){
                url += 'user_id=' + userId + '&';
            }

            if(fromDate != ''){
                url += 'from_date=' + fromDate + '&';
            }

            if(toDate != ''){
                url += 'to_date=' + toDate + '&';
            }

            console.log(url);
            //  url = '{!! route('admin.purchases.data') !!}?user_id=' + userId 
            // + '&branch_id=' + branchId + '&from_date=' +
            //     fromDate + '&to_date=' + toDate;
            table.api().ajax.url(url).load(function() {
                if (table.fnSettings().fnRecordsTotal() === 0) {
            alert('No data available.');
        }
                
            });

        });
        

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

                    var url = "{{ route('admin.purchases.destroy', ':id') }}";
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
                                //                                    swal("Deleted!", response.message, "success");
                                table._fnDraw();
                            }
                        }
                    });
                }
            });

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
