<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary">
    <p class="login-logo-dashboard-custom">@lang('app.projectName')</p>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" id="sidebarnav" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon icon-speedometer"></i>
                        <p>
                            @lang('menu.dashboard')
                        </p>
                    </a>
                </li>

                <!-- <li class="nav-header" style="padding-top:0rem; background-color:#79AEC8; color:#FFFFFF;">ACCOUNTS AND USERS</li> -->
                <!-- <li class="nav-header" style="padding-top:0rem;">ACCOUNTS AND USERS</li> -->
             

                @if (in_array('view_menu', $userPermissions))
                    <li class="nav-item">
                        <a href="{{ route('admin.menu.index') }}"
                            class="nav-link {{ request()->is('admin/menu*') ? 'active' : '' }}">
                             <i class="fa fa-bars"></i>
                            <p>
                                @lang('menu.menus')
                            </p>
                        </a>
                    </li>
                @endif

                @if (in_array('view_sliders', $userPermissions))
                <li class="nav-item">
                    <a href="{{ route('admin.sliders.index') }}"
                        class="nav-link {{ request()->is('admin/sliders*') ? 'active' : '' }}">
                           <i class="fa fa-image"></i>
                        <p>
                            @lang('menu.sliders')
                        </p>
                    </a>
                </li>
            @endif

            @if (in_array('view_slidercards', $userPermissions))
            <li class="nav-item">
                <a href="{{ route('admin.slidercards.index') }}"
                    class="nav-link {{ request()->is('admin/slidercards*') ? 'active' : '' }}">
                         <i class="fa fa-credit-card"></i>
                    <p>
                        @lang('menu.slidercards')
                    </p>
                </a>
            </li>
        @endif
                 @if (in_array('view_overviews', $userPermissions))
                    <li class="nav-item">
                        <a href="{{ route('admin.overviews.index') }}"
                            class="nav-link {{ request()->is('admin/overviews*') ? 'active' : '' }}">
                            <i class="fa fa-line-chart"></i>
                            <p>
                                @lang('menu.overviews')
                            </p>
                        </a>
                    </li>
                @endif
                @if (in_array('view_features', $userPermissions))
                            <li class="nav-item">
                                <a href="{{ route('admin.features.index') }}"
                                    class="nav-link {{ request()->is('admin/features') ? 'active' : '' }}">
                                    <i class="fa fa-cogs"></i>
                                    <p>
                                        @lang('menu.features')
                                    </p>
                                </a>
                            </li>
                        @endif
              

                @if (in_array('view_clientsoverview', $userPermissions))
                <li class="nav-item">
                    <a href="{{ route('admin.clientsoverview.index') }}"
                        class="nav-link {{ request()->is('admin/clientsoverview*') ? 'active' : '' }}">
                        <i class="fa fa-shopping-cart"></i>
                        <p>
                            @lang('menu.clientsoverview')
                        </p>
                    </a>
                </li>
            @endif
                 
                  
  @if (in_array('manage_settings', $userPermissions))
                <li class="nav-item has-treeview @if (\Request()->is('admin/settings/*') || \Request()->is('admin/profile')) active menu-open @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon icon-settings"></i>
                        <p>
                            @lang('menu.settings')
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                     
                            <li class="nav-item">
                                <a href="{{ route('admin.settings.index') }}"
                                    class="nav-link {{ request()->is('admin/settings/settings') ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>@lang('menu.companySettings')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.role-permission.index') }}"
                                    class="nav-link {{ request()->is('admin/settings/role-permission') ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>@lang('menu.rolesPermissions')</p>
                                </a>
                            </li>
                       
                    </ul>
                </li>
                @endif
            </ul>



                {{-- @if (in_array('view_feedbacks', $userPermissions))
                    <li class="nav-item">
                        <a href="{{ route('admin.feedbacks.index') }}"
                            class="nav-link {{ request()->is('admin/feedbacks*') ? 'active' : '' }}">
                            <i class="nav-icon icon-film"></i>
                            <p>
                                @lang('menu.feedback')
                            </p>
                        </a>
                    </li>
                @endif --}}

                {{-- @if (in_array('view_user', $userPermissions))
                    <li class="nav-item">
                        <a href="{{ route('admin.user.index') }}"
                            class="nav-link {{ request()->is('admin/user') ? 'active' : '' }}">
                            <i class="nav-icon icon-people"></i>
                            <p>
                                @lang('menu.user')
                            </p>
                        </a>
                    </li>
                @endif --}}

                {{-- @if (in_array('manage_user_reports', $userPermissions) || in_array('view_user_reports', $userPermissions) || in_array('view_gift_reports', $userPermissions))
                <li class="nav-item has-treeview @if (\Request()->is('admin/userreports*') || \Request()->is('admin/user-reports') || \Request()->is('admin/gift-reports')) active menu-open @endif">
           
                    <a href="#" class="nav-link">
                    <i class="nav-icon icon-people"></i>
                        <p>
                            @lang('menu.userreports')
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                      

                        @if (in_array('view_user_reports', $userPermissions))
                            <li class="nav-item">
                                <a href="{{ route('admin.user-reports.index') }}"
                                    class="nav-link {{ request()->is('admin/user-reports') ? 'active' : '' }}">
                                    <i class="nav-icon icon-people"></i>
                                    <p>
                                        @lang('menu.userwisereports')
                                    </p>
                                </a>
                            </li>
                            
                        @endif
                       
                       

                    </ul>
                </li>
                @endif --}}


                {{-- @if (in_array('view_coupon_users', $userPermissions))
                <li class="nav-header" style="padding-top:1.5rem;">REWARD APP</li>
              

              
                    <li class="nav-item">
                        <a href="{{ route('admin.couponuses.index') }}"
                            class="nav-link {{ request()->is('admin/couponuses*') ? 'active' : '' }}">
                            <i class="fa fa-credit-card"></i>
                            <p>
                                @lang('menu.couponuses')
                            </p>
                        </a>
                    </li>
                @endif --}}
                
               

                
                {{-- @if (in_array('view_gift', $userPermissions))
                    <li class="nav-item">
                        <a href="{{ route('admin.gifts.index') }}"
                            class="nav-link {{ request()->is('admin/gifts*') ? 'active' : '' }}">
                            <i class="fa fa-gift"></i>
                            <p>
                                @lang('menu.gifts')
                            </p>
                        </a>
                    </li>
                @endif --}}

                {{-- @if (in_array('view_product', $userPermissions))
                    <li class="nav-item">
                        <a href="{{ route('admin.product.index') }}"
                            class="nav-link {{ request()->is('admin/product*') ? 'active' : '' }}">
                            <i class="fa fa-mobile"></i>
                            <p>
                                @lang('menu.product')
                            </p>
                        </a>
                    </li>
                @endif --}}

              

             

                {{-- @if (in_array('view_purchases', $userPermissions))
                    <li class="nav-item">
                        <a href="{{ route('admin.purchases.index') }}"
                            class="nav-link {{ request()->is('admin/purchases*') ? 'active' : '' }}">
                            <i class="fa fa-money"></i>
                            <p>
                                @lang('menu.purchases')
                            </p>
                        </a>
                    </li>
                @endif --}}

             

                {{-- @if (in_array('view_sms_logs', $userPermissions))
                    <li class="nav-item">
                        <a href="{{ route('admin.smslogs.index') }}"
                            class="nav-link {{ request()->is('admin/smslogs*') ? 'active' : '' }}">
                            <i class="fa fa-comment"></i>
                            <p>
                                @lang('menu.smslogs')
                            </p>
                        </a>
                    </li>
                @endif --}}

                {{-- @if (in_array('view_update_logs', $userPermissions))
                    <li class="nav-item">
                        <a href="{{ route('admin.updatelogs.index') }}"
                            class="nav-link {{ request()->is('admin/updatelogs*') ? 'active' : '' }}">
                            <i class="fa fa-wrench"></i>
                            <p>
                                @lang('menu.updatelogs')
                            </p>
                        </a>
                    </li>
                @endif --}}
                
                {{-- @if (in_array('view_event_logs', $userPermissions))
                    <li class="nav-item">
                        <a href="{{ route('admin.eventlogs.index') }}"
                            class="nav-link {{ request()->is('admin/eventlogs*') ? 'active' : '' }}">
                            <i class="fa fa-wrench"></i>
                            <p>
                                @lang('menu.eventlogs')
                            </p>
                        </a>
                    </li>
                @endif --}}

{{-- 
                @if (in_array('view_app_configs', $userPermissions) || in_array('view_coupons', $userPermissions) || in_array('view_categories', $userPermissions))
                <li class="nav-item has-treeview @if (\Request()->is('admin/app-configs*') || \Request()->is('admin/coupon') || \Request()->is('admin/end-devices') || \Request()->is('admin/categories') || \Request()->is('admin/sub-categories')) active menu-open @endif">
                    <a href="#" class="nav-link">
                        <i class="fa fa-cogs"></i>
                        <p>
                            @lang('menu.configuration')
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (in_array('view_app_configs', $userPermissions))
                            <li class="nav-item">
                                <a href="{{ route('admin.app-configs.index') }}"
                                    class="nav-link {{ request()->is('admin/app-configs*') ? 'active' : '' }}">
                                    <i class="nav-icon icon-grid"></i>
                                    <p>
                                        @lang('menu.appConfigs')
                                    </p>
                                </a>
                            </li>
                        @endif

                        @if (in_array('view_coupon', $userPermissions))
                            <li class="nav-item">
                                <a href="{{ route('admin.coupon.index') }}"
                                    class="nav-link {{ request()->is('admin/coupon') ? 'active' : '' }}">
                                    <i class="fa fa-ticket"> </i>
                                    <p>
                                        @lang('menu.coupon')
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (in_array('view_app_configs', $userPermissions))
                            <li class="nav-item">

                                <a href="{{ route('admin.coupon.index') }}"
                                    class="nav-link {{ request()->is('admin/coupon') ? 'active' : '' }}">
                                    <i class="fa fa-sort-numeric-desc"> </i>
                                    <p>
                                        @lang('menu.pointconfiguration')
                                    </p>
                                </a>
                            </li>
                        @endif

                        @if (in_array('view_end_devices', $userPermissions))
                            <li class="nav-item">
                                <a href="{{ route('admin.end-devices.index') }}"
                                    class="nav-link {{ request()->is('admin/end-devices*') ? 'active' : '' }}">
                                    <i class="fa fa-desktop"></i>
                                    <p>
                                        @lang('menu.endDevices')
                                    </p>
                                </a>
                            </li>
                        @endif  --}}
                
 {{-- @if (in_array('view_product_category', $userPermissions))
                    <li class="nav-item">
                        <a href="{{ route('admin.categories.index') }}"
                            class="nav-link {{ request()->is('admin/categories') ? 'active' : '' }}">
                            <i class="fa fa-tags"></i>
                            <p>
                                @lang('menu.categories')
                            </p>
                        </a>
                    </li>
                @endif --}}
     {{-- @if (in_array('view_sub_category', $userPermissions))
                            <li class="nav-item">
                                <a href="{{ route('admin.sub-categories.index') }}"
                                    class="nav-link {{ request()->is('admin/sub-categories') ? 'active' : '' }}">
                                    <i class="fa fa-tags"></i>
                                    <p>
                                        @lang('menu.subcategories')
                                    </p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                @endif --}}

              
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
