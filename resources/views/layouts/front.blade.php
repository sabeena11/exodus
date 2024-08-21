<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="manifest" href="{{ asset('favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <title>{{ $global->company_name }}</title>

    <style>
        :root {
            --main-color: {{ config('app.mainColor') }};
        }
    </style>
    <!-- page css -->
    <link href="{{ asset('assets/dist/css/adminlte.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/iCheck/square/blue.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">

    <!-- Css -->
    <link href="{{ asset('assets/front/libs/tobii/css/tobii.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/libs/tiny-slider/tiny-slider.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/libs/swiper/css/swiper.min.css') }}" rel="stylesheet">
    <!-- Main Css -->
    <link href="{{ asset('assets/front/libs/@iconscout/unicons/css/line.css') }}" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/tailwind.css') }}" />
    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body class="font-nunito text-base text-black dark:text-white dark:bg-slate-900">
    <!-- Header -->

    <nav id="topnav" class="defaultscroll is-sticky">

        <div class="container">

            <!-- Logo container-->
            <a class="logo" href="index.html">
                <span class="inline-block dark:hidden">
                    <img src="{{ asset('assets/front/images/logo-dark.png') }}" class="l-dark" height="24"
                        alt="">
                    <img src="{{ asset('assets/images/logo-light.png') }}" class="l-light" height="24"
                        alt="">
                </span>
                <img src="{{ asset('assets/images/logo-light.png') }}" height="24"
                    class="hidden dark:inline-block" alt="">
            </a>

            <!-- End Logo container-->

            <div class="menu-extras">

                <div class="menu-item">

                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </div>
            </div>

            <div id="navigation">

                <!-- Navigation Menu-->
                <ul class="navigation-menu nav-light">
                    @foreach ($menus as $menu)
                        @if ($menu->section == 'Navbar')
                            <li><a href="#" class="sub-menu-item">{{ $menu->title }}</a></li>
                        @endif
                    @endforeach

                </ul><!--end navigation menu-->

            </div><!--end navigation-->

        </div><!--end container-->

    </nav>

    <!-- END Header -->

    <!-- Main container -->
    @yield('content')

    <!-- Footer -->
    <footer class="footer bg-dark-footer relative text-gray-200 dark:text-gray-200">
        <div class="container">

            <div class="grid grid-cols-12">
                <div class="col-span-12">
                    <div class="py-[60px] px-0">

                        <div class="grid md:grid-cols-12 grid-cols-1 gap-[30px]">

                            <div class="lg:col-span-2 md:col-span-4">

                                <h5 class="tracking-[1px] text-gray-100 font-semibold">Company</h5>
                                <ul class="list-none footer-list mt-6">
                                    @foreach ($menus as $menu)
                                        @if ($menu->section == 'Company')
                                            <li><a href="#"
                                                    class="text-gray-300 hover:text-gray-400 duration-500 ease-in-out"><i
                                                        class="uil uil-angle-right-b me-1"></i>
                                                    {{ $menu->title }}</a></li>
                                            {{-- <li class="mt-[10px]"><a href="#" class="text-gray-300 hover:text-gray-400 duration-500 ease-in-out"><i class="uil uil-angle-right-b me-1"></i> Services</a></li>
                                    <li class="mt-[10px]"><a href="#" class="text-gray-300 hover:text-gray-400 duration-500 ease-in-out"><i class="uil uil-angle-right-b me-1"></i> Team</a></li> --}}
                                        @endif
                                    @endforeach

                                </ul>

                            </div><!--end col-->




                            <div class="lg:col-span-3 md:col-span-4">
                                <h5 class="tracking-[1px] text-gray-100 font-semibold">Usefull Links</h5>
                                <ul class="list-none footer-list mt-6">
                                    @foreach ($menus as $menu)
                                        @if ($menu->section == 'Useful Links')
                                            <li><a href="#"
                                                    class="text-gray-300 hover:text-gray-400 duration-500 ease-in-out"><i
                                                        class="uil uil-angle-right-b me-1"></i>
                                                    {{ $menu->title }}</a></li>
                                            {{-- <li class="mt-[10px]"><a href="#" class="text-gray-300 hover:text-gray-400 duration-500 ease-in-out"><i class="uil uil-angle-right-b me-1"></i> Privacy Policy</a></li> --}}
                                        @endif
                                    @endforeach
                                </ul>
                            </div><!--end col-->

                            <div class="lg:col-span-3 md:col-span-4">
                            </div>

                            <div class="lg:col-span-3 md:col-span-4">
                                <img src="{{ asset('assets/front/images/logo-light.png') }}" alt="">
                                <ul class="list-none mt-6">
                                    <li class="inline"><a href="{{ $global->linkedin_url }}"
                                            target="_blank"
                                            class="btn btn-icon btn-sm border border-gray-800 rounded-md hover:border-indigo-600 dark:hover:border-indigo-600 hover:bg-indigo-600 dark:hover:bg-indigo-600"><i
                                                class="uil uil-linkedin" title="Linkedin"></i></a></li>
                                    <li class="inline"><a href="{{ $global->facebook_url }}"
                                            target="_blank"
                                            class="btn btn-icon btn-sm border border-gray-800 rounded-md hover:border-indigo-600 dark:hover:border-indigo-600 hover:bg-indigo-600 dark:hover:bg-indigo-600"><i
                                                class="uil uil-facebook-f align-middle" title="facebook"></i></a></li>
                                    <li class="inline"><a href="{{ $global->instagram_url }}"
                                            target="_blank"
                                            class="btn btn-icon btn-sm border border-gray-800 rounded-md hover:border-indigo-600 dark:hover:border-indigo-600 hover:bg-indigo-600 dark:hover:bg-indigo-600"><i
                                                class="uil uil-instagram align-middle" title="instagram"></i></a></li>
                                    <li class="inline"><a href="{{ $global->twitter_url }}" target="_blank"
                                            class="btn btn-icon btn-sm border border-gray-800 rounded-md hover:border-indigo-600 dark:hover:border-indigo-600 hover:bg-indigo-600 dark:hover:bg-indigo-600"><i
                                                class="uil uil-twitter align-middle" title="twitter"></i></a></li>
                                </ul><!--end icon-->
                            </div><!--end col-->
                        </div><!--end grid-->

                    </div><!--end col-->
                </div>
            </div><!--end grid-->

        </div><!--end container-->
    </footer>
    <!-- END Footer -->

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('assets/front/libs/tobii/js/tobii.min.js') }}"></script>
    <script src="{{ asset('assets/front/libs/tiny-slider/min/tiny-slider.js') }}"></script>
    <script src="{{ asset('assets/front/libs/swiper/js/swiper.min.js') }}"></script>
    <script src="{{ asset('assets/front/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/plugins.init.js') }}"></script>
    <script src="{{ asset('assets/front/js/app.js') }}"></script>

    <!--Custom JavaScript -->
    <script type="text/javascript"></script>

</body>

</html>
