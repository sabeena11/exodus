@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
@endpush

@if (in_array('add_branches', $userPermissions))
    @section('create-button')
        <a href="{{ route('admin.branches.create') }}" class="btn btn-dark btn-sm m-l-15"><i class="fa fa-plus-circle"></i>
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
                                    <th class="noExport">@lang('app.branch.image')</th>
                                    <th>@lang('app.branch.name')</th>
                                     <!-- <th>@lang('app.branch.unique_id')</th> -->
                                    <th>@lang('app.branch.paired')</th>
                                    <th>@lang('app.branch.address')</th>
                                    <th>@lang('app.branch.contact_person')</th>

                                    <th>@lang('app.branch.phone')</th>
                                    <th>@lang('app.branch.email')</th>
                                    <th>@lang('app.branch.desc')</th>
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
            ajax: '{!! route('admin.branches.data') !!}',
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
                    render: function(data, type, row) {
                        if (type === 'display') {
                            var baseUrl = "{{ url('/') }}"; 
                            return '<a href="' + baseUrl + '/admin/branches/' + data + '/edit">'  + data + '</a>';
                        }
                        return data;
                    }
                },
                 {
    data: 'image',
    name: 'image',
     width:'10%',
    render: function(data, type, row, meta) {
        if (type === 'display') {
            return '<div style="width: 100px; height: 100px; overflow: hidden; position: relative;">' +
                        '<a href="{{ asset('user-uploads/branches/') }}/' + data +'" target="_blank">' +
                            '<img src="{{ asset('user-uploads/branches/') }}/' + data + '"class="img-thumbnail" alt="Image" style="width: 100%; height: 100%; object-fit: cover;">' +
                        '</a>' +
                '</div>';
        }
        return data;
    }
},

                {
                    data: 'name',
                    name: 'name',
                      width:'15%'
                },

                // {data: 'unique_id', name: 'unique_id',  width:'1%'},
                {data: 'paired', name: 'paired',  width:'1%'},
                 {
                    data: 'address',
                    name: 'address',
                    width:'15%'
                },
                 {
                    data: 'contact_person',
                    name: 'contact_person',
                    width:'14%'
                },
                 {
                    data: 'phone',
                    name: 'phone',
                    width:'10%'
                },
                {
                    data: 'email',
                    name: 'email',
                    width:'5%'
                },
                {
                    data: 'desc',
                    name: 'desc',
                    width:'19%'
                },
                {
                    data: 'action',
                    name: 'action',
                    width:'6%'

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

                    var url = "{{ route('admin.branches.destroy', ':id') }}";
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
                        //swal("Deleted!", response.message, "success");
                        table._fnDraw();
                    }
                }
            })
        });
    </script>
@endpush
