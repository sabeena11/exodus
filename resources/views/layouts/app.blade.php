<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Favicon icon -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <title>@lang('app.projectName') | {{ $pageTitle }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- Simple line icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">

   <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Themify icons -->
    <link rel="stylesheet" href="{{ asset('assets/icons/themify-icons/themify-icons.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->

    <link href="{{ asset('helper/helper.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/node_modules/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <link rel='stylesheet prefetch' href='https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.0/dist/css/bootstrap-select.min.css'>

    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link href="{{ asset('assets/node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/Magnific-Popup-master/dist/magnific-popup.css') }}">

    @stack('head-script')

    <link rel='stylesheet prefetch'
          href='//cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css'>

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <style>
        :root {
            --main-color: {{ config('app.mainColor') }};
        }
        .well, pre {
            background: #fff;
            border-radius: 0;
        }

        .btn-group-xs > .btn, .btn-xs {
            padding  : .25rem .4rem;
            font-size  : .875rem;
            line-height  : .5;
            border-radius : .2rem;
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            padding: 6px 0;
            border-radius: 15px;
            text-align: center;
            font-size: 12px;
            line-height: 1.428571429;
        }
        .well {
            min-height: 20px;
            padding: 19px;
            margin-bottom: 20px;
            background-color: #f5f5f5;
            border: 1px solid #e3e3e3;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
            font-size: 12px;
        }
        .text-truncate-notify{
            white-space: pre-wrap !important;
        }

        .image-container {
            display: flex;
            align-items: center;
        }

        .image-container .image {
            display: inline-block;
            position: relative;
            width: 32px;
            height: 32px;
            overflow: hidden;
            border-radius: 50%;
            margin-right: 10px;
        }

        .image-container .image img {
            width: auto;
            height: 100%;
        }

        #top-notification-dropdown>a {
            position: relative;
        }

        #top-notification-dropdown>a span {
            position: absolute;
            right: 10%;
            top: 10%;
        }

        #top-notification-dropdown>a span.badge {
            padding: 2px 5px;
        }

        .scrollable {
            max-height: 250px;
            overflow-y: scroll;
        }
    </style>

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                    <a class="image-container nav-link waves-effect waves-light"
                    @if(!$user->is_superadmin)
                        href="{{ route('admin.profile.index') }}"
                    @else
                        href="{{ route('superadmin.profile.index') }}"
                    @endif
                    >
                        <div class="image">
                            <img src="{{ $user->profile_image_url  }}" alt="User Image" >
                        </div>
                        <span>{{ ucwords($user->name) }}</span>
                    </a>
    
                </li>

            <!-- Notifications Dropdown Menu -->
            <!-- <li class="nav-item dropdown" id="top-notification-dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell-o"></i>
                    @if(count($user->unreadNotifications) > 0)
                        <span class="badge badge-warning navbar-badge ">{{ count($user->unreadNotifications) }}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <div class="scrollable">
                        @foreach ($user->unreadNotifications as $notification)
                            @include('notifications.'.snake_case(class_basename($notification->type)))
                        @endforeach
                    </div>
                    @if(count($user->unreadNotifications) > 0)
                        <a id="mark-notification-read" href="javascript:void(0);" class="dropdown-item dropdown-footer">@lang('app.markNotificationRead') <i class="fa fa-check"></i></a>
                    @else
                        <a  href="javascript:void(0);" class="dropdown-item dropdown-footer">@lang('messages.notificationNotFound') </a>
                    @endif
                </div>
            </li> -->
            <li class="nav-item">
                <a class="nav-link  waves-effect waves-light" href="{{ route('logout') }}" title="Logout" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
                ><i class="fa fa-power-off"></i>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </a>

            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    @include('sections.left-sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        @include('sections.breadcrumb')

        <!-- Main content -->
        <section class="content">

            @yield('content')

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-lg in" id="application-lg-modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> @lang('app.cancel')</button>
                    <button type="button" class="btn btn-success"><i class="fa fa-check"></i> @lang('app.save')</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Ajax Modal Ends--}}

    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="application-md-modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> @lang('app.cancel')</button>
                    <button type="button" class="btn btn-success"><i class="fa fa-check"></i> @lang('app.save')</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Ajax Modal Ends--}}


    <footer class="main-footer">
        &copy; {{ \Carbon\Carbon::today()->year }} {{ $companyName }}
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/node_modules/popper/popper.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.js') }}"></script>

<!-- SlimScroll -->
<script src="{{ asset('assets/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('assets/plugins/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>

<script src='https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.0/dist/js/bootstrap-select.min.js'></script>
<script src="{{ asset('assets/node_modules/sweetalert/sweetalert.min.js') }}"></script>

<script src="{{ asset('helper/helper.js') }}"></script>
<script src="{{ asset('assets/node_modules/toast-master/js/jquery.toast.js') }}"></script>
<script src="{{ asset('js/cbpFWTabs.js') }}"></script>
<script src="{{ asset('assets/plugins/icheck/icheck.min.js') }}"></script>
<script src="{{ asset('assets/plugins/icheck/icheck.init.js') }}"></script>
<script src="{{ asset('assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup-init.js') }}"></script>
<!-- Datatable Buttons -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/buttons.dataTables.min.css') }}">
<script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>


<script>
    $('body').on('click', '.right-side-toggle', function () {
        $("body").removeClass("control-sidebar-slide-open");
    })

    $(function () {
        $('.selectpicker').selectpicker({
            style: 'btn-info',
            size: 4
        });
    });

    function languageOptions() {
        return {
            processing:     "@lang('app.datatables.processing')",
            search:         "@lang('app.datatables.search')",
            lengthMenu:    "@lang('app.datatables.lengthMenu')",
            info:           "@lang('app.datatables.info')",
            infoEmpty:      "@lang('app.datatables.infoEmpty')",
            infoFiltered:   "@lang('app.datatables.infoFiltered')",
            infoPostFix:    "@lang('app.datatables.infoPostFix')",
            loadingRecords: "@lang('app.datatables.loadingRecords')",
            zeroRecords:    "@lang('app.datatables.zeroRecords')",
            emptyTable:     "@lang('app.datatables.emptyTable')",
            paginate: {
                first:      "@lang('app.datatables.paginate.first')",
                previous:   "@lang('app.datatables.paginate.previous')",
                next:       "@lang('app.datatables.paginate.next')",
                last:       "@lang('app.datatables.paginate.last')",
            },
            aria: {
                sortAscending:  "@lang('app.datatables.aria.sortAscending')",
                sortDescending: "@lang('app.datatables.aria.sortDescending')",
            },
        }
    }

    $('#mark-notification-read').click(function () {
        var token = '{{ csrf_token() }}';
        $.easyAjax({
            type: 'POST',
            url: '{{ route("mark-notification-read") }}',
            data: {'_token': token},
            success: function (data) {
                if (data.status == 'success') {
                    $('.top-notifications').remove();
                    $('#top-notification-dropdown .notify').remove();
                    window.location.reload();
                }
            }
        });

    });

    // $('body').on('click', '.view-notification', function(event) {
    $('.read-notification').click(function () {
        event.preventDefault();
        var id = $(this).data('notification-id');
        //  var href = $(this).attr('href');
        var dataUrl = $(this).data('link');

        $.easyAjax({
            url: "{{ route('mark_single_notification_read') }}",
            type: "POST",
            data: {
                '_token': "{{ csrf_token() }}",
                'id': id
            },
            success: function() {

                if (typeof dataUrl !== 'undefined') {
                    window.location = dataUrl;
                }
            }
        });
    });

    // search input implementation
    function search($input, doneTypingInterval, type) {
        var $anchor = $input.siblings('a');
        var typingTimer, fn;

        if (type == 'data') {
            fn = loadData;
        }
        if (type == 'table') {
            fn = redrawTable;                    
        }

        $input.on('keyup', function (e) {
            if ($(this).val() !== '' || ($(this).val().length >= 0 && e.key === 'Backspace')) {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => {
                    fn();
                }, doneTypingInterval);
            }

            $(this).val() !== '' ? $anchor.removeClass('d-none') : $anchor.addClass('d-none');
        })

        $input.on('keydown', function () {
            clearTimeout(typingTimer);
        });

        $anchor.click(function(e) {
            $(this).siblings('input').val('');
            fn();
            $anchor.addClass('d-none');
            $(this).siblings('input').focus();
        })
    }

    $('body').on('click', '.toggle-password', function() {
        var $selector = $(this).parent().find('input.form-control');
        $(this).toggleClass("fa-eye fa-eye-slash");
        var $type = $selector.attr("type") === "password" ? "text" : "password";
        $selector.attr("type", $type);
    });

</script>

@stack('footer-script')

</body>
</html>
