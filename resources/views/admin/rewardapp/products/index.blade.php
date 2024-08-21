@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
@endpush

@if(in_array("add_product", $userPermissions))
    @section('create-button')
        <a href="{{ route('admin.product.create') }}" class="btn btn-dark btn-sm m-l-15"><i
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
                                    <th class="noExport">@lang('app.product.image')</th>
                                    <th>@lang('app.product.name')</th>
                                    <th>@lang('app.product.price')</th>
                                    <th>@lang('app.product.discount')</th>
                                    <th>@lang('app.product.category')</th>
                                    <th>@lang('app.product.desc')</th>
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
            ajax: '{!! route('admin.product.data') !!}',
                pageLength: 100,
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
                            return '<a href="' + baseUrl + '/admin/product/' + data + '/edit">'  + data + '</a>';
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
            return '<div style="width: 100px; height: 100px; overflow: hidden; position: relative;  justify-content: center; align-items: center;">' +
                        '<a href="{{ asset('user-uploads/product/') }}/' + data + '"  target="_blank">' +
                            '<img src="{{ asset('user-uploads/product/') }}/' + data + '" class="img-thumbnail" alt="Image" style="width: 100%; height: 100%; object-fit: cover;">' +
                        '</a>' +
                '</div>';
        }
        return data;
    }
},

                { data: 'name', name: 'name' ,
                    width:'15%'},
                { data: 'price', name: 'price' ,
                    width:'5%'},
                { data: 'discount', name: 'discount' ,
                    width:'5%'},
                { data: 'subcategory', name: 'subcategory' ,
                    width:'10%'},
                { data: 'desc', name: 'desc' ,
                    width:'41%'},
                { data: 'action', name: 'action' ,
                    width:'6%'}
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

                        var url = "{{ route('admin.product.destroy', ':id') }}";
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

