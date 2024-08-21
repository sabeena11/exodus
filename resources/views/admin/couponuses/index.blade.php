@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
@endpush




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
                                    <th>@lang('app.couponuse.coupon')</th>
                                    <th>@lang('app.couponuse.user')</th>
                                    <th>@lang('app.couponuse.created')</th>
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
            serverSide: true,
            ajax: '{!! route('admin.couponuses.data') !!}',
                pageLength: 100,
            language: languageOptions(),
            "fnDrawCallback": function (oSettings) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            },
            columns: [
                { 
                    data: 'id',
                    name: 'id',
                    width:'5%',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            var baseUrl = "{{ url('/') }}"; 
                            return '<a href="' + baseUrl + '/admin/couponuses/' + data + '/edit">'  + data + '</a>';
                        }
                        return data;
                    } 
                },
        { data: 'coupon_name', name: 'coupon_name',width:'30%' },
        { data: 'user_name', name: 'user_name',    width:'30%' },
        { data: 'created', name: 'created',  width:'29%' },
        { data: 'action', name: 'action',  width:'6%' }
    ],

        });

        new $.fn.dataTable.FixedHeader(table);

        $('body').on('click', '.sa-params', function () {
            var id = $(this).data('row-id');
            var deleteUrl = $(this).data('url');
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

                        var url = "{{ route('admin.couponuses.destroy', ':id') }}";
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
        })

    </script>
@endpush

