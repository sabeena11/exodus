<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
//clear cache route
Route::get('/clear-all-cache',function(){
    Artisan::call('optimize:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    return 'Success';

});

Route::group(
    ['namespace' => 'Front', 'as' => 'jobs.'],
    function () {
        Route::get('/', 'FrontController@index')->name('index')->Middleware('disable-frontend');
        // Route::Post('disable-job-alert/{id}', 'FrontJobsController@disableJobAlert')->name('disableJobAlert');
    }
);

// Admin routes
Route::group(
    ['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'],
    function () {
        Route::get('/dashboard', 'AdminDashboardController@index')->name('dashboard');
           Route::get('/getPointsData', 'AdminDashboardController@getPointsData')->name('getPointsData');
           Route::get('/dashboard/data', 'AdminDashboardController@data')->name('dashboarddata');
          

        // Route::resource('app-configs', 'AppConfigController', ['only' => ['edit', 'update', 'index']]);

        //Route::resource('notifications', 'CompanySettingsController', ['only' => ['edit', 'update', 'index']]);
        // Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        // Route::get('notifications/add', [NotificationController::class, 'add'])->name('notifications.add');
        // Route::match(['get', 'post'],'notifications/save', [NotificationController::class, 'save'])->name('notifications.save');
        // Route::match(['get', 'post'],'notifications/delete/{id}', [NotificationController::class, 'delete'])->name('notifications.delete');
        // Route::match(['get', 'post'],'notifications/edit/{id}', [NotificationController::class, 'edit'])->name('notifications.edit');
        Route::get('notifications/data', 'NotificationController@data')->name('notifications.data');
        Route::resource('notifications', 'NotificationController');
        


        // Route::resource('feedbacks', 'UserFeedbackController', ['only' => ['edit', 'update', 'index']]);

        Route::get('app-configs/data', 'AppConfigController@data')->name('app-configs.data');
        Route::resource('app-configs', 'AppConfigController');

        Route::get('feedbacks/data', 'UserFeedbackController@data')->name('feedbacks.data');
        Route::resource('feedbacks', 'UserFeedbackController');

        Route::get('user/data', 'AdminUserController@data')->name('user.data');
        Route::post('user/change-role', 'AdminUserController@changeRole')->name('user.changeRole');
        Route::resource('user', 'AdminUserController');

        Route::get('gift-reports/data', 'GiftReportController@data')->name('gift-reports.data');
        Route::resource('gift-reports', 'GiftReportController');

        Route::get('features/data', 'FeatureController@data')->name('features.data');
        Route::resource('features', 'FeatureController');

        Route::get('overviews/data', 'OverviewController@data')->name('overviews.data');
        Route::resource('overviews', 'OverviewController');
        
        Route::get('banners/data', 'SlidingBannerController@data')->name('banners.data');
        Route::resource('banners', 'SlidingBannerController');
            
        Route::get('sliders/data', 'SliderController@data')->name('sliders.data');
        Route::resource('sliders', 'SliderController');

        Route::get('slidercards/data', 'SliderCardController@data')->name('slidercards.data');
        Route::resource('slidercards', 'SliderCardController');

        Route::get('categories/data', 'CaregoriesController@data')->name('categories.data');
        Route::resource('categories', 'CaregoriesController');

        Route::get('sub-categories/data', 'SubCategoriesController@data')->name('sub-categories.data');
        Route::resource('sub-categories', 'SubCategoriesController');
        
        // Route::get('categories', [CaregoriesController::class, 'index'])->name('categories.index');
        // Route::get('categories/add', [CaregoriesController::class, 'add'])->name('categories.add');
        // Route::post('categories/save', [CaregoriesController::class, 'save'])->name('categories.save');
        // Route::match(['get', 'post'],'categories/delete/{id}', [CaregoriesController::class, 'delete'])->name('categories.delete');
		// Route::match(['get', 'post'],'categories/edit/{id}', [CaregoriesController::class, 'edit'])->name('categories.edit');
		// Route::match(['get', 'post'],'categories/update', [CaregoriesController::class, 'update'])->name('categories.update');

        // Route::match(['get', 'post'],'product/', [ProductController::class, 'index'])->name('product.index');
        // Route::match(['get', 'post'],'products/{id}', [ProductController::class, 'index'])->name('product.index.no-id');
        // Route::match(['get', 'post'],'product/add', [ProductController::class, 'add'])->name('product.add');
        // Route::match(['get', 'post'],'product/save', [ProductController::class, 'save'])->name('product.save');
        // Route::match(['get', 'post'],'product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
        // Route::match(['get', 'post'],'product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        // Route::match(['get', 'post'],'product/update', [ProductController::class, 'update'])->name('product.update');

        Route::get('product/data', 'ProductController@data')->name('product.data');
        Route::resource('product', 'ProductController');

        // Route::get('coupon-uses/data', 'AdminUserController@data')->name('coupon-uses.data');
        //Route::resource('coupon-uses', 'AdminUserController');

        Route::get('coupons/data', 'CouponController@data')->name('coupons.data');
        Route::resource('coupons', 'CouponController');

        Route::get('end-devices/data', 'EndDeviceController@data')->name('end-devices.data');
        Route::resource('end-devices', 'EndDeviceController');

    
        Route::get('gifts/data', 'GiftsController@data')->name('gifts.data');
        Route::resource('gifts', 'GiftsController');

        Route::get('smslogs/data', 'SmsLogsController@data')->name('smslogs.data');
        Route::resource('smslogs', 'SmsLogsController');
        
        Route::resource('coupon', 'CouponController');
        
        Route::get('purchases/pdf', 'PurchasesController@convert_to_pdf')->name('purchases.pdf');
        Route::get('purchases/data', 'PurchasesController@data')->name('purchases.data');
        Route::resource('purchases', 'PurchasesController');

        Route::get('purchaseitem/data', 'PurchaseItemController@data')->name('purchaseitem.data');
        Route::resource('purchaseitem', 'PurchaseItemController');

        Route::get('couponuses/data', 'CouponUsesController@data')->name('couponuses.data');
        Route::resource('couponuses', 'CouponUsesController');

        
        Route::get('updatelogs/data', 'UpdateLogsController@data')->name('updatelogs.data'); 
        Route::resource('updatelogs', 'UpdateLogsController');

         Route::get('eventlogs/data', 'EventLogController@data')->name('eventlogs.data'); 
        Route::resource('eventlogs', 'EventLogController');

        Route::get('menu/data', 'MenuController@data')->name('menu.data');
        Route::resource('menu','MenuController');
        
        Route::get('clientsoverview/data', 'ClientsOverviewController@data')->name('clientsoverview.data');
        Route::resource('clientsoverview','ClientsOverviewController');
        // company settings
        
        Route::group(
            ['prefix' => 'settings'],
            function () {
                // Company Setting routes
                Route::resource('settings', 'CompanySettingsController', ['only' => ['edit', 'update', 'index']]);

                // Role permission routes
                Route::post('role-permission/assignAllPermission', ['as' => 'role-permission.assignAllPermission', 'uses' => 'ManageRolePermissionController@assignAllPermission']);
                Route::post('role-permission/removeAllPermission', ['as' => 'role-permission.removeAllPermission', 'uses' => 'ManageRolePermissionController@removeAllPermission']);
                Route::post('role-permission/assignRole', ['as' => 'role-permission.assignRole', 'uses' => 'ManageRolePermissionController@assignRole']);
                Route::post('role-permission/detachRole', ['as' => 'role-permission.detachRole', 'uses' => 'ManageRolePermissionController@detachRole']);
                Route::post('role-permission/storeRole', ['as' => 'role-permission.storeRole', 'uses' => 'ManageRolePermissionController@storeRole']);
                Route::post('role-permission/deleteRole', ['as' => 'role-permission.deleteRole', 'uses' => 'ManageRolePermissionController@deleteRole']);
                Route::get('role-permission/showMembers/{id}', ['as' => 'role-permission.showMembers', 'uses' => 'ManageRolePermissionController@showMembers']);
                Route::resource('role-permission', 'ManageRolePermissionController');
            }
        );

        Route::resource('profile', 'AdminProfileController');

        Route::resource('company', 'AdminCompanyController');
    }
);

Route::get('remove-session', 'VerifyMobileController@removeSession')->name('removeSession');

Route::group(['middleware' => 'auth'], function () {
    Route::post('mark-notification-read', ['uses' => 'NotificationController@markAllRead'])->name('mark-notification-read');
    Route::post('mark-read', 'NotificationController@markRead')->name('mark_single_notification_read');
});