@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
@endpush

{{-- @if (in_array('add_user', $userPermissions))
@section('create-button')
    <a href="{{ route('admin.updatelogs.create') }}" class="btn btn-dark btn-sm m-l-15"><i
                class="fa fa-plus-circle"></i> @lang('app.createNew')</a>
@endsection
@endif --}}

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
                                    <th>@lang('app.eventlogs.user_id')</th>
                                    <th>@lang('app.eventlogs.title')</th>
                                    <th>@lang('app.eventlogs.desc')</th>
                                    <th>@lang('app.eventlogs.image')</th>
                                    <th>@lang('app.coupon.startdate')</th>
                                    <th>@lang('app.coupon.enddate')</th>
                                    <th>@lang('app.eventlogs.created')</th>
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
            // serverSide: true,
            ajax: '{!! route('admin.eventlogs.data') !!}',
            order: [[7, 'desc']],
            pageLength: 100,
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
                    // render: function(data, type, row) {
                    //     if (type === 'display') {
                    //         var baseUrl = "{{ url('/') }}"; 
                    //         return '<a href="' + baseUrl + '/admin/eventlogs/' + data + '/edit">'  + data + '</a>';
                    //     }
                    //     return data;
                    // }
                },
                {
                    data: 'user_name',
                    name: 'name',
                    width:'10%'
                },
                {
                    data: 'title',
                    name: 'title',
                    width:'15%'
                },
                {
                    data: 'desc',
                    name: 'desc',
                    width:'25%'
                },
                {
                    data: 'image',
                    name: 'image',
                    width:'10%',
                    render: function(data, type, row, meta) {
                        if (type === 'display') {
                            return'<div style="width: 100px; height: 100px; overflow: hidden; position: relative;">' +
                        '<a href="{{ asset('user-uploads/eventlogs/') }}/' + data + '" target="_blank">' +
                            '<img src="{{ asset('user-uploads/eventlogs/') }}/' + data + '" class="img-thumbnail" alt="Image" style="width: 100%; height: 100%; object-fit: cover;">' +
                        '</a>' +
                '</div>';
                    }
                        return data;
                
                }
                },
                {
                    data: 'start_date',
                    name: 'start_date',
                    width:'10%'
                },
                {
                    data: 'end_date',
                    name: 'end_date',
                    width:'10%'
                },
                {
                    data: 'created_at',
                    name: 'created',
                    width:'15%'
                }
            ],
        });

        new $.fn.dataTable.FixedHeader(table);

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

                    var url = "{{ route('admin.eventlogs.destroy', ':id') }}";
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
                                //        swal("Deleted!", response.message, "success");
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
    </script>
@endpush
