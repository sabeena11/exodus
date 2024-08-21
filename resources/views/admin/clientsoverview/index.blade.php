@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
@endpush

@if (in_array('add_clientsoverview', $userPermissions))
    @section('create-button')
        <a href="{{ route('admin.clientsoverview.create') }}" class="btn btn-dark btn-sm m-l-15"><i class="fa fa-plus-circle"></i>
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
                                    
                                    <th class="noExport">@lang('app.clientsoverview.image')</th>
                                    <th>@lang('app.clientsoverview.desc')</th>
                                    <th>@lang('app.clientsoverview.name')</th>
                                    <th>@lang('app.clientsoverview.designation')</th>
                                    <th>@lang('app.clientsoverview.rating_star')</th>
                              
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
            ajax: '{!! route('admin.clientsoverview.data') !!}',
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
                    width:'6%',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            var baseUrl = "{{ url('/') }}"; 
                            return '<a href="' + baseUrl + '/admin/clientsoverview/' + data + '/edit">'  + data + '</a>';
                        }
                        return data;
                    },
                },
                {
                    data: 'image',
                    name: 'image',
                    width: '18%',
                    render: function(data, type, row, meta) {
                        if (type === 'display') {
                            return '<div style="width: 100%; height: 100%; overflow: hidden; position: relative;  justify-content: center; align-items: center;">' +
                                '<a href="{{ asset('user-uploads/clientsoverview/') }}/' + data + '" target="_blank">' +
                                '<img src="{{ asset('user-uploads/clientsoverview/') }}/' + data +
                                '" class="img-thumbnail" alt="Image" style="width: 350px; height: auto; max-width: 100%; max-height: 180px; ">' +
                                '</a>' +
                                '</div>';
                        }
                        return data;
                    }
                },

                {
                    data: 'desc',
                    name: 'desc',
                    width: '20%',
                },
                {
                    data: 'name',
                    name: 'name',
                    width: '14%',
                },
                {
                    data: 'designation',
                    name: 'designation',
                    width: '17%',
                },
                {
                    data: 'rating_star',
                    name: 'rating_star',
                    width: '15%',
                    render: function(data, type, row) {
        // Assuming 'icon' data contains the rating (e.g., a number from 1 to 5)
        var stars = '';
        var rating = parseInt(data); // Convert data to integer if necessary

        // Loop to create star icons based on rating value
        for (var i = 1; i <= 5; i++) {
            if (i <= rating) {
                stars += '<i class="fa fa-star text-warning"></i>'; // Example: Font Awesome star icon
            } else {
                stars += '<i class="fa fa-star-o text-warning"></i>'; // Example: Font Awesome outline star icon
            }
        }

        return stars;
    },
                },
               
             

                {
                    data: 'action',
                    name: 'action',
                    width: '10%',
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

                    var url = "{{ route('admin.clientsoverview.destroy', ':id') }}";
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
