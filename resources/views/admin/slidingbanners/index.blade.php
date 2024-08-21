@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
@endpush

@if (in_array('add_banners', $userPermissions))
    @section('create-button')
        <a href="{{ route('admin.banners.create') }}" class="btn btn-dark btn-sm m-l-15"><i class="fa fa-plus-circle"></i>
            @lang('app.createNew')</a>
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
                                    <th class="noExport">@lang('app.banners.image')</th>
                                    <th>@lang('app.banners.title')</th>
                                    <th>@lang('app.banners.views')</th>
                                    <th>@lang('app.banners.priority')</th>
                                    <th>@lang('app.banners.created')</th>
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
            ajax: '{!! route('admin.banners.data') !!}',
            pageLength: 100,
            order: [[5, 'desc']],
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
                            return '<a href="' + baseUrl + '/admin/banners/' + data + '/edit">'  + data + '</a>';
                        }
                        return data;
                    },
                },
                {
                    data: 'image',
                    name: 'image',
                    width: '30%',
                    render: function(data, type, row, meta) {
                        if (type === 'display') {
                            return '<div style="width: 100%; height: 100%; overflow: hidden; position: relative;  justify-content: center; align-items: center;">' +
                                '<a href="{{ asset('user-uploads/banners/') }}/' + data + '" target="_blank">' +
                                '<img src="{{ asset('user-uploads/banners/') }}/' + data +
                                '" class="img-thumbnail" alt="Image" style="width: 350px; height: auto; max-width: 100%; max-height: 180px; ">' +
                                '</a>' +
                                '</div>';
                        }
                        return data;
                    }
                },

                {
                    data: 'title',
                    name: 'title',
                    width: '33%',
                },

                {
                    data: 'views',
                    name: 'views',
                    width: '6%',
                },
                {
                    data: 'priority',
                    name: 'priority',
                    width: '5%',
                },
                {
                    data: 'created',
                    name: 'created',
                    width: '15%',
                },

                {
                    data: 'action',
                    name: 'action',
                    width: '6%',
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

                    var url = "{{ route('admin.banners.destroy', ':id') }}";
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
                        //                                    swal("Deleted!", response.message, "success");
                        table._fnDraw();
                    }
                }
            })
        });
    </script>
@endpush
