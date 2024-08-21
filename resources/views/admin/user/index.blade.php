@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
@endpush

@if(in_array("add_user", $userPermissions))
@section('create-button')
    <a href="{{ route('admin.user.create') }}" class="btn btn-dark btn-sm m-l-15"><i
                class="fa fa-plus-circle"></i> @lang('app.createNew')</a>
@endsection
@endif

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="card">
         
                   
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th>@lang('app.user.name')</th>
                                <th>@lang('app.user.email')</th>
                                <th>@lang('app.user.roleName')</th>
                              
                                <th>@lang('app.user.verified')</th>
                                <th>@lang('app.user.is_staff')</th>
                                <th>@lang('app.user.last_login')</th>
                                <th>@lang('app.user.point')</th>
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

    <script>
        
        var table = $('#myTable').dataTable({
            responsive: true,
            // processing: true,
            serverSide: true,
           
            pageLength: 100,
  
            ajax: '{!! route('admin.user.data') !!}',
               
            language: languageOptions(),
            "fnDrawCallback": function (oSettings) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            },
            columns: [
                {   data: 'id',
                    name: 'id',
                    width:'5%',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            var baseUrl = "{{ url('/') }}"; 
                            return '<a href="' + baseUrl + '/admin/user/' + data + '/edit">'  + data + '</a>';
                        }
                        return data;
                    }
                },
                {data: 'name', name: 'name',  width:'24%'},
                {data: 'email', name: 'email',    width:'25%'},
                {data: 'role_name', name: 'role_name',  width:'14%'},
                {data: 'is_verified', name: 'is_verified',width:'5%'},
                {data: 'is_staff', name: 'is_staff',width:'6%'},
                {data: 'last_login', name: 'last_login',width:'10%'},
                {data: 'point', name: 'point',width:'5%'},
                {data: 'action', name: 'action', width:'6%'}

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

        $('body').on('click', '.sa-params', function () {
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
            }, function (isConfirm) {
                if (isConfirm) {

                    var url = "{{ route('admin.user.destroy',':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {
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

        $('body').on('change', '.role_id', function () {
            var id = $(this).val();
            var userId = $(this).data('row-id');
            var url = '{{route('admin.user.changeRole')}}';

            $.easyAjax({
                url: url,
                type: 'POST',
                data: {roleId: id, userId: userId, _token: '{{ csrf_token() }}'},
                success: function (response) {
                    if (response.status == "success") {
                        $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                        table._fnDraw();
                    }
                }
            })
        });


    </script>
@endpush
