<?php

/*
|--------------------------------------------------------------------------
| SPA Auth Routes
|--------------------------------------------------------------------------
|
| These routes are prefixed with '/'.
| These routes use the root namespace 'App\Http\Controllers\Web'.
|
 */

use App\Base\Constants\Auth\Role;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Web\Admin\PDFController;

/*
 * These routes are used for web authentication.
 *
 * Route prefix 'api/spa'.
 * Root namespace 'App\Http\Controllers\Web\Admin'.
 */

/**
 * Temporary dummy route for testing SPA.
 */


Route::middleware('guest')->namespace('Admin')->group(function () {

    // Get admin-login form
    Route::get('login', 'AdminViewController@viewLogin');
    //dispatcher Login
    Route::get('/login-dispatch', 'AdminViewController@viewDispatchLogin');
    



//forgot Password
    Route::get('forgot_password', 'AdminViewController@forgotPassword');
    Route::post('forgot_password', 'AdminViewController@sendLink');
    Route::get('reset-password/{token}', 'AdminViewController@showResetPasswordForm')->name('reset.password.get');
    Route::post('reset-password', 'AdminViewController@submitResetPasswordForm')->name('reset.password.post');


    Route::get('company-login', 'FleetOwnerController@viewLogin');
   
    Route::get('login/{provider}', 'AdminViewController@redirectToProvider');

    Route::get('login/callback/{provider}', 'AdminViewController@handleProviderCallback');
});

Route::middleware('auth:web')->group(function () {

        //cMS
    Route::group(['prefix' => 'cms'], function () {
    
            Route::post('/frontpagecmsadd','FrontPageController@frontpageadd')->name('frontpagecmsadd');
            Route::get('/frontpagecms', 'FrontPageController@frontpage')->name('frontpagecms');
            Route::post('/safetypageadd','FrontPageController@safetypagecmsadd')->name('safetypageadd');
            Route::get('/safetypagecms', 'FrontPageController@safetypagecms')->name('safetypagecms');
            Route::post('/servicepageadd','FrontPageController@servicepagecmsadd')->name('servicepageadd');
            Route::get('/servicepage', 'FrontPageController@servicepagecms')->name('servicepage');
            Route::post('/privacypageadd','FrontPageController@privacypagecmsadd')->name('privacypageadd');
            Route::get('/privacypagecms', 'FrontPageController@privacypagecms')->name('privacypagecms');
            Route::post('/dmvpageadd','FrontPageController@dmvpagecmsadd')->name('dmvpageadd');
            Route::get('/dmvpagecms', 'FrontPageController@dmvpagecms')->name('dmvpagecms');
            Route::post('/complaincepageadd','FrontPageController@complaincepagecmsadd')->name('complaincepageadd');
            Route::get('/complaincepagecms', 'FrontPageController@complaincepagecms')->name('complaincepagecms');
            Route::post('/termspageadd','FrontPageController@termspagecmsadd')->name('termspageadd');
            Route::get('/termspagecms', 'FrontPageController@termspagecms')->name('termspagecms');
            Route::post('/drreqpageadd','FrontPageController@drreqpagecmsadd')->name('drreqpageadd');
            Route::get('/drreqpagecms', 'FrontPageController@drreqpagecms')->name('drreqpagecms');
            Route::post('/applydriverpageadd','FrontPageController@applydriverpagecmsadd')->name('applydriverpageadd');
            Route::get('/applydriverpagecms', 'FrontPageController@applydriverpagecms')->name('applydriverpagecms');
            Route::post('/howdriverpageadd','FrontPageController@howdriverpagecmsadd')->name('howdriverpageadd');
            Route::get('/howdriverpagecms', 'FrontPageController@howdriverpagecms')->name('howdriverpagecms');
            Route::post('/contactpageadd','FrontPageController@contactpagecmsadd')->name('contactpageadd');
            Route::get('/contactpagecms', 'FrontPageController@contactpagecms')->name('contactpagecms');
            Route::post('/playstorepageadd','FrontPageController@playstorepagecmsadd')->name('playstorepageadd');
            Route::get('/playstorepagecms', 'FrontPageController@playstorepagecms')->name('playstorepagecms');
            Route::post('/footerpageadd','FrontPageController@footerpagecmsadd')->name('footerpageadd');
            Route::get('/footerpagecms', 'FrontPageController@footerpagecms')->name('footerpagecms');
            Route::post('/colorthemepageadd','FrontPageController@colorthemepagecmsadd')->name('colorthemepageadd');
            Route::get('/colorthemepagecms', 'FrontPageController@colorthemepagecms')->name('colorthemepagecms');

    });

    Route::namespace('Admin')->group(function () {
        Route::get('dispatcher-request','AdminViewController@dispatchRequest');
    // Owner Management (Company Management)
    Route::group(['prefix' => 'owners'], function () {
        // Route::get('/', 'OwnerController@index')->name('ownerView');
        // Route::get('/fetch', 'OwnerController@getAllOwner');
        Route::get('by_area/{area}', 'OwnerController@index')->name('ownerByArea');
        Route::get('by_area/fetch/{area}', 'OwnerController@getAllOwner');
        Route::get('/create/{area}', 'OwnerController@create');
        Route::post('store', 'OwnerController@store');
        Route::get('/{owner}', 'OwnerController@getById');
        Route::post('update/{owner}', 'OwnerController@update');
        Route::get('toggle_status/{owner}', 'OwnerController@toggleStatus');
        Route::get('toggle_approve/{owner}', 'OwnerController@toggleApprove');
        Route::get('delete/{owner}', 'OwnerController@delete');
        Route::get('get/owner', 'OwnerController@getOwnerByArea')->name('getOwnerByArea');
        Route::get('document/view/{owner}', 'OwnerDocumentController@index')->name('ownerDocumentView');
        Route::get('upload/document/{owner}/{needed_document}', 'OwnerDocumentController@documentUploadView')->name('uploadOwnerDocument');;
        Route::post('upload/document/{owner}/{needed_document}', 'OwnerDocumentController@uploadDocument')->name('updateOwnerDocument');
        Route::post('approve/documents', 'OwnerDocumentController@approveOwnerDocument')->name('approveOwnerDocument');
        Route::get('payment-history/{owner}', 'OwnerController@OwnerPaymentHistory');
        Route::post('payment-history/{owner}', 'OwnerController@StoreOwnerPaymentHistory');

    });

    // Fleet CRUD
    Route::group(['prefix' => 'fleets'], function () {
        Route::get('/', 'FleetController@index')->name('viewFleet');
        Route::get('/fetch', 'FleetController@fetch')->name('fetchFleet');
        Route::get('/create', 'FleetController@create')->name('createFleet');
        Route::post('store', 'FleetController@store')->name('storeFleet');
        Route::get('edit/{fleet}', 'FleetController@getById')->name('editFleet');
        Route::post('update/{fleet}', 'FleetController@update')->name('updateFleet');
        Route::get('toggle_status/{fleet}', 'FleetController@toggleStatus')->name('toggleFleetStatus');
        Route::get('toggle_approve/{fleet}', 'FleetController@toggleApprove')->name('toggleFleetApprove');
        Route::get('delete/{fleet}', 'FleetController@delete')->name('deleteFleet');
        Route::post('update/decline/reason', 'FleetController@updateFleetDeclineReason')->name('updateFleetDeclineReason');
        Route::get('assign_driver/{fleet}', 'FleetController@assignDriverView')->name('assignFleetToDriverView');
        Route::post('assign_driver/{fleet}', 'FleetController@assignDriver')->name('assignFleetToDriver');
        Route::get('document/view/{fleet}', 'FleetDocumentController@index')->name('FleetDocumentView');
        Route::get('upload/document/{fleet}/{needed_document}', 'FleetDocumentController@documentUploadView');
        Route::post('upload/document/{fleet}/{needed_document}', 'FleetDocumentController@uploadDocument')->name('updateFleetDocument');
        Route::post('approve/documents', 'FleetDocumentController@approveFleetDocument')->name('approveFleetDocument');

    });

    // Driver Management
    Route::group(['prefix' => 'company/drivers','namespace'=>'Company'], function () {
        // prefix('drivers')->group(function () {
        Route::get('/', 'DriverController@index')->name('companyDriverView');
        Route::get('/fetch', 'DriverController@getAllDrivers');
        Route::get('/create', 'DriverController@create');
        Route::post('store', 'DriverController@store');
        Route::get('/{driver}', 'DriverController@getById');
        Route::post('update/{driver}', 'DriverController@update');
        Route::get('toggle_status/{driver}', 'DriverController@toggleStatus');
        Route::get('toggle_approve/{driver}', 'DriverController@toggleApprove');
        Route::get('toggle_available/{driver}', 'DriverController@toggleAvailable');
        Route::get('delete/{driver}', 'DriverController@delete');
        Route::get('document/view/{driver}', 'DriverDocumentController@index')->name('companyDriverDocumentView');
        Route::get('get/carmodel', 'DriverController@getCarModel')->name('getCarModel');
        Route::get('profile/{driver}', 'DriverController@profile');
        Route::get('hire/view', 'DriverController@hireDriverView')->name('hireDriverView');
        Route::post('hire', 'DriverController@hireDriver')->name('hireDriver');
        Route::get('vehicle/privileges/{driver}','DriverController@fleetPrivilegeView')->name('fleetPrivilegeView');
        Route::post('store/vehicle/privileges/{driver}','DriverController@storePrivilegedVehicle')->name('storePrivilegedVehicle');
        Route::get('unlink/fleet/{driver}/{vehicle}','DriverController@unlinkVehicle')->name('unlinkVehicle');
    });

});
});



Route::middleware('guest')->namespace('Dispatcher')->group(function () {
    // Get admin-login form
    Route::get('dispatch-login', 'DispatcherController@loginView');
});


Route::namespace('Admin')->group(function () {
    Route::get('track/request/{request}', 'AdminViewController@trackTripDetails');
});


Route::middleware('auth:web')->group(function () {

    Route::post('logout', function () {
        auth('web')->logout();
        request()->session()->invalidate();
        return redirect('login');
    });
    // Masters Crud
    Route::middleware(role_middleware(Role::webPanelLoginRoles()))->group(function () {
        /**
         * Vehicle Types
         */
        Route::namespace('Admin')->group(function () { 
         
            Route::prefix('types')->group(function () {
                Route::get('/', 'Roomcontroller@index');
                Route::get('/availability-view', 'Roomcontroller@availability_view');
                Route::get('/fetch', 'Roomcontroller@getAllTypes');
                Route::get('/availability-view/fetch', 'Roomcontroller@availability_view_fetch');
                Route::get('by/admin', 'Roomcontroller@byAdmin');
                Route::post('/check-availability', 'Roomcontroller@check_availability');
                Route::post('/book-now', 'Roomcontroller@book_now');
                Route::post('/store', 'Roomcontroller@store');
                Route::get('edit/{booking}', 'Roomcontroller@edit');
                Route::get('view/{booking}', 'Roomcontroller@view');
                Route::get('view-invoice/{booking}', 'Roomcontroller@view_invoice');
                Route::get('/export_pdf/{booking}', 'Roomcontroller@export');
                Route::post('/confirm-checkin/{booking}', 'Roomcontroller@confirm_checkin');
                Route::post('/confirm-checkout/{booking}', 'Roomcontroller@confirm_checkout');
                Route::get('cancel-booking/{booking}', 'Roomcontroller@cancel_booking');
                Route::get('approve-booking/{booking}', 'Roomcontroller@approve_booking');
                Route::post('/update/{vehicle_type}', 'Roomcontroller@update');
                Route::get('toggle_status/{vehicle_type}', 'Roomcontroller@toggleStatus');
                Route::get('/delete/{vehicle_type}', 'Roomcontroller@delete');
            });
            Route::prefix('party')->group(function () {
                Route::get('/', 'PartyController@index');
                Route::get('/fetch', 'PartyController@getAllTypes');
                Route::post('/book-now', 'PartyController@book_now');
                Route::post('/check-availability', 'PartyController@check_availability');
                Route::get('by/admin', 'PartyController@byAdmin');
                Route::get('/create', 'PartyController@create');
                Route::post('/store', 'PartyController@store');
                Route::get('edit/{booking}', 'PartyController@edit');
                Route::get('view/{booking}', 'PartyController@view');
                Route::get('cancel-booking/{booking}', 'PartyController@cancel_booking'); 
                Route::post('/update/{vehicle_type}', 'PartyController@update');
                Route::get('toggle_status/{vehicle_type}', 'PartyController@toggleStatus');
                Route::get('/delete/{vehicle_type}', 'PartyController@delete');
                Route::get('view-invoice/{booking}', 'PartyBookingController@view_invoice');
                Route::get('/export_pdf/{booking}', 'PartyBookingController@export');
                Route::post('/confirm-checkin/{booking}', 'PartyBookingController@confirm_checkin');
                Route::get('/confirm-checkout/{booking}', 'PartyBookingController@confirm_checkout');
            });
            Route::prefix('lawn')->group(function () {
                Route::get('/', 'LawnController@index');
                Route::get('/fetch', 'LawnController@getAllTypes');
                Route::post('/check-availability', 'LawnController@check_availability');
                Route::post('/book-now', 'LawnController@book_now');
                Route::get('/create', 'LawnController@create');
                Route::post('/store', 'LawnController@store');
                Route::get('edit/{booking}', 'LawnController@edit');
                Route::get('view/{booking}', 'LawnController@view');
                Route::get('cancel-booking/{booking}', 'LawnController@cancel_booking');
                Route::post('/update/{vehicle_type}', 'LawnController@update');
                Route::get('toggle_status/{vehicle_type}', 'LawnController@toggleStatus');
                Route::get('/delete/{vehicle_type}', 'LawnController@delete');
            });
            Route::prefix('sports')->group(function () {
                Route::get('/', 'SportsController@index');
                Route::get('/update-tariff', 'SportsController@update_tariff');
                Route::get('/fetch', 'SportsController@getAllTypes');
                Route::post('/check-availability', 'SportsController@check_availability');
                Route::post('/book-now', 'SportsController@book_now');
                Route::get('by/admin', 'SportsController@byAdmin');
                Route::get('/create', 'SportsController@create');
                Route::post('/store', 'SportsController@store');
                Route::get('edit/{id}', 'SportsController@edit');
                Route::get('view/{booking}', 'SportsController@view');
                Route::post('/update/{vehicle_type}', 'SportsController@update');
                Route::get('toggle_status/{vehicle_type}', 'SportsController@toggleStatus');
                Route::get('/delete/{vehicle_type}', 'SportsController@delete');
                Route::get('cancel-booking/{booking}', 'SportsController@cancel_booking');
                Route::get('confirm-booking/{booking}', 'SportsController@confirm_booking');
            });
            Route::prefix('room-booking')->group(function () {
                Route::get('/', 'BookingController@index');
                Route::get('/update-tariff', 'BookingController@update_tariff');
                Route::get('/fetch', 'BookingController@getAllTypes');
                Route::get('/fetch1', 'BookingController@getAllTypes1');
                Route::post('/check-availability', 'BookingController@check_availability');
                Route::post('/book-now', 'BookingController@book_now');
                Route::get('by/admin', 'BookingController@byAdmin');
                Route::get('/create', 'BookingController@create');
                Route::post('/store', 'BookingController@store');
                Route::get('edit/{id}', 'BookingController@edit');
                Route::get('view/{booking}', 'BookingController@view');
                Route::post('/update/{vehicle_type}', 'BookingController@update');
                Route::get('toggle_status/{vehicle_type}', 'BookingController@toggleStatus');
                Route::get('/delete/{vehicle_type}', 'BookingController@delete');
                Route::get('/apply-filters', 'BookingController@apply_filters');
            });
            Route::prefix('party-booking')->group(function () {
                Route::get('/', 'PartyBookingController@index');
                Route::get('/update-tariff', 'PartyBookingController@update_tariff');
                Route::get('/fetch', 'PartyBookingController@getAllTypes');
                Route::post('/check-availability', 'PartyBookingController@check_availability');
                Route::post('/book-now', 'PartyBookingController@book_now');
                Route::get('by/admin', 'PartyBookingController@byAdmin');
                Route::get('/create', 'PartyBookingController@create');
                Route::post('/store', 'PartyBookingController@store');
                Route::get('edit/{id}', 'PartyBookingController@edit');
                Route::get('view/{booking}', 'PartyBookingController@view');
                Route::post('/update/{vehicle_type}', 'PartyBookingController@update');
                Route::get('toggle_status/{vehicle_type}', 'PartyBookingController@toggleStatus');
                Route::get('/delete/{vehicle_type}', 'PartyBookingController@delete');
            });
            Route::prefix('sports-booking')->group(function () {
                Route::get('/', 'SportsBookingController@index');
                Route::get('/update-tariff', 'SportsBookingController@update_tariff');
                Route::get('/fetch', 'SportsBookingController@getAllTypes');
                Route::post('/check-availability', 'SportsBookingController@check_availability');
                Route::post('/book-now', 'SportsBookingController@book_now');
                Route::get('by/admin', 'SportsBookingController@byAdmin');
                Route::get('/create', 'SportsBookingController@create');
                Route::post('/store', 'SportsBookingController@store');
                Route::get('edit/{id}', 'SportsBookingController@edit');
                Route::get('view/{booking}', 'SportsBookingController@view');
                Route::post('/update/{vehicle_type}', 'SportsBookingController@update');
                Route::get('toggle_status/{vehicle_type}', 'SportsBookingController@toggleStatus');
                Route::get('/delete/{vehicle_type}', 'SportsBookingController@delete');
                Route::get('view-invoice/{booking}', 'SportsBookingController@view_invoice');
                Route::get('/export_pdf/{booking}', 'SportsBookingController@export');
                Route::get('/test/{booking}', 'SportsBookingController@test');
            });
            Route::prefix('tariff')->group(function () {
                Route::get('/', 'TariffController@index'); 
                Route::post('/save-tariff', 'TariffController@store'); 
            });
        });
        Route::namespace('Admin')->group(function () {
            Route::get('view-services', 'AdminViewController@viewServices');
            Route::prefix('officers')->group(function () {
                Route::get('/', 'OfficerController@index');
                Route::get('/fetch', 'OfficerController@getAllTypes');
                Route::get('by/admin', 'OfficerController@byAdmin');
                Route::get('/create', 'OfficerController@create');
                Route::post('/store', 'OfficerController@store');
                Route::get('edit/{id}', 'OfficerController@edit');
                Route::post('/update/{vehicle_type}', 'OfficerController@update');
                Route::get('toggle_status/{vehicle_type}', 'OfficerController@toggleStatus');
                Route::get('/delete/{vehicle_type}', 'OfficerController@delete');
            });
        });
    });

    Route::namespace('Admin')->group(function () {
        // Change Locale
        Route::get('/change/lang/{lang}', 'AdminViewController@changeLocale')->name('changeLocale');

        // Route::get('dashboard', 'DashboardController@dashboard');
        Route::get('dashboard', 'NewDashboardController@dashboard');
        Route::post('/export_pdf', 'NewDashboardController@export');
        Route::get('/download-pdf', 'NewDashboardController@sample');
        Route::get('driver_stats', 'NewDashboardController@stats');


        // Route::get('dashboard', 'AdminViewController@dashboard');
        Route::get('/admin_dashboard', 'AdminViewController@viewTestDashboard')->name('admin_dashboard');
        Route::get('/driver_profile_dashboard', 'AdminViewController@driverPrfDashboard')->name('driver_profile_dashboard');
        Route::get('/driver_profile_dashboard_view/{driver}', 'AdminViewController@driverPrfDashboardView');

        Route::group(['prefix' => 'company',  'middleware' => 'permission:view-companies'], function () {
            // prefix('company')->group(function () {
            Route::get('/', 'CompanyController@index');
            Route::get('/fetch', 'CompanyController@getAllCompany');
            Route::get('by/admin', 'CompanyController@byAdmin');
            Route::get('/create', 'CompanyController@create');
            Route::post('store', 'CompanyController@store');
            Route::get('edit/{company}', 'CompanyController@getById');
            Route::post('update/{company}', 'CompanyController@update');
            Route::get('toggle_status/{company}', 'CompanyController@toggleStatus');
            Route::get('delete/{company}', 'CompanyController@delete');
        });

//drivers

    Route::group(['prefix' => 'drivers'], function () {
        Route::get('/', 'DriverController@index');
        Route::get('/fetch/approved', 'DriverController@getApprovedDrivers');
        Route::get('/list-notes', 'DriverController@ListNotes');
        Route::get('/list-note', 'DriverController@ListNote');
        Route::get('/add-notes', 'DriverController@AddNotes');
        Route::get('/add-note', 'DriverController@AddNote');
        Route::get('/assign-employees', 'DriverController@AssignEmployees');
        Route::get('/add-decomposition', 'DriverController@AddDecomposition');
        Route::get('/add-decomposition1', 'DriverController@AddDecomposition1');
        Route::get('/SendForapproval/{driver}', 'DriverController@SendForapproval');
        

//searchAllDrivers
        Route::get('/search', 'DriverController@searchAllDrivers');


        Route::any('/reports/download', 'DriverController@reportDownload');

        Route::get('/registered', 'DriverController@registerdDrivers');
        Route::get('/fetch/registered', 'DriverController@getRegistered');
        Route::get('/registered/delete/{driver}', 'DriverController@registeredDelete');


        Route::get('/waiting-for-approval', 'DriverController@approvalPending');
        // Route::get('/fetch', 'DriverController@getAllDrivers');
        Route::get('/fetch/approval-pending-drivers', 'DriverController@getApprovalPendingDrivers');
        Route::get('/fetch/driver-ratings', 'DriverController@fetchDriverRatings');

        Route::get('/deleted-drivers', 'DriverController@deletedDrivers');
        Route::get('/fetch/deleted-drivers', 'DriverController@getDeletedDrivers');
        
        Route::get('/restricted-drivers', 'DriverController@restrictedDrivers');
        Route::get('/fetch/restricted-drivers', 'DriverController@getRestrictedDrivers');

        Route::get('/create', 'DriverController@create');
        Route::post('store', 'DriverController@store');
        Route::get('/{driver}', 'DriverController@getById');
        Route::get('request-list/{driver}', 'DriverController@DriverTripRequestIndex');
        Route::get('request-list/{driver}/fetch', 'DriverController@DriverTripRequest');
        Route::get('payment-history/{driver}', 'DriverController@DriverPaymentHistory');
        Route::post('payment-history/{driver}', 'DriverController@StoreDriverPaymentHistory');

        Route::get('payment-history/delete/{driver}', 'DriverController@DriverPaymentdelete');

        Route::post('update/{driver}', 'DriverController@update');
        Route::get('toggle_status/{driver}', 'DriverController@toggleStatus');
        Route::get('toggle_approve/{driver}/{approval_status}', 'DriverController@toggleApprove');
        Route::get('toggle_available/{driver}', 'DriverController@toggleAvailable');
        Route::get('delete/{driver}', 'DriverController@delete');
        Route::get('document/view/{driver}', 'DriverDocumentController@index');
        Route::get('upload/document/{driver}/{needed_document}', 'DriverDocumentController@documentUploadView');
        Route::post('upload/document/{driver}/{needed_document}', 'DriverDocumentController@uploadDocument');
        Route::post('approve/documents', 'DriverDocumentController@approveDriverDocument')->name('approveDriverDocument');
        Route::get('get/carmodel', 'DriverController@getCarModel')->name('getCarModel');
        Route::post('update/decline/reason', 'DriverController@UpdateDriverDeclineReason')->name('UpdateDriverDeclineReason');
        Route::post('/import-driver', 'DriverController@importDriver'); 
        Route::get('/download', 'DriverController@downloadFile');  

        Route::post('get_invoice', 'DriverController@getInvoice')->name('get_invoice');  
        Route::post('check_invoice_exists', 'DriverController@checkInvoiceExists')->name('CheckInvoiceExists');  

        Route::get('/list-invoice/{driver}', 'DriverController@listInvoice');  
        Route::get('invoice/delete/{driver_invoice}', 'DriverController@invoiceDelete');
        Route::post('welcome_call', 'DriverController@welcomeCall')->name('welcome_call');  
        Route::post('free_trail', 'DriverController@freeTrail')->name('free_trail');  
        Route::get('/invoice/{driver_invoice}', 'DriverController@viewInvoice');
        Route::get('/generate-invoice/{driver_invoice}', 'DriverController@generateInvoicePDF')->name('generate-invoice.pdf');
        Route::get('/export_pdf', 'DriverController@export');
        Route::get('/subscriptions/{driver}', 'DriverController@subscriptions');  
        Route::get('/subscription-invoice/{driver_subscription}', 'DriverController@subscriptionInvoice');
        Route::get('/generate-pdf/{driver_subscription}', 'DriverController@generatePDF')->name('generate.pdf');
        Route::get('/driver-details-generate-pdf/{driver}', 'DriverController@generateDriverDetailsPDF')->name('generate-driver-details.pdf');


        Route::get('cancellation-wallet/{driver}', 'DriverController@DriverCancelRequestIndex');

       
        });

        Route::group(['prefix'=>'driver-ratings'], function () {
             Route::get('/','DriverController@driverRatings');
             Route::get('/view/{driver}','DriverController@driverRatingView');
        });
         Route::group(['prefix'=>'withdrawal-requests-lists'], function () {
             Route::get('/','DriverController@withdrawalRequestsList');
             Route::get('/view/{driver}','DriverController@withdrawalRequestDetail');
             Route::get('/approve/{wallet_withdrawal_request}','DriverController@approveWithdrawalRequest');
             Route::get('/decline/{wallet_withdrawal_request}','DriverController@declineWithdrawalRequest');
       Route::get('/negative_balance_drivers','DriverController@NeagtiveBalanceDrivers');
       Route::get('fetch/negative-balance-drivers', 'DriverController@NegativeBalanceFetch');
        });

//Fleet drivers

    Route::group(['prefix' => 'fleet-drivers'], function () {
        // prefix('drivers')->group(function () {
        Route::get('/', 'FleetDriverController@index');
        Route::get('/fetch/approved', 'FleetDriverController@getApprovedFleetDrivers');

        Route::get('/waiting-for-approval', 'FleetDriverController@approvalPending');
        // Route::get('/fetch', 'DriverController@getAllDrivers');
        Route::get('/fetch/approval-pending-drivers', 'FleetDriverController@getApprovalPendingFleetDrivers');
        Route::get('/fetch/driver-ratings', 'FleetDriverController@fetchFleetDriverRatings');

        Route::get('/create', 'FleetDriverController@create');
        Route::post('store', 'FleetDriverController@store');
        Route::get('/{driver}', 'FleetDriverController@getById');
        Route::get('request-list/{driver}', 'FleetDriverController@DriverTripRequestIndex');
        Route::get('request-list/{driver}/fetch', 'FleetDriverController@FleetDriverTripRequest');
        Route::get('payment-history/{driver}', 'FleetDriverController@FleetDriverPaymentHistory');
        Route::post('payment-history/{driver}', 'FleetDriverController@StoreFleetDriverPaymentHistory');
        Route::post('update/{driver}', 'FleetDriverController@update');
        Route::get('toggle_status/{driver}', 'FleetDriverController@toggleStatus');
        Route::get('toggle_approve/{driver}/{approval_status}', 'FleetDriverController@toggleApprove');
        Route::get('toggle_available/{driver}', 'FleetDriverController@toggleAvailable');
        Route::get('delete/{driver}', 'FleetDriverController@delete');
        Route::get('document/view/{driver}', 'FleetDriverDocumentController@index');
        Route::get('upload/document/{driver}/{needed_document}', 'FleetDriverDocumentController@documentUploadView');
        Route::post('upload/document/{driver}/{needed_document}', 'FleetDriverDocumentController@uploadDocument');
        Route::post('approve/documents', 'FleetDriverDocumentController@approveFleetDriverDocument')->name('approveFleetDriverDocument');
        Route::get('get/carmodel', 'FleetDriverController@getCarModel')->name('getCarModel');
        Route::post('update/decline/reason', 'FleetDriverController@UpdateDriverDeclineReason')->name('UpdateFleetDriverDeclineReason');
       
        });
        Route::prefix('clf-profile')->group(function () {
            Route::get('/', 'CLFProfileController@index'); 
            Route::get('/fetch', 'CLFProfileController@getAllUser');
            Route::get('clf_profile/{profile}', 'AdminController@viewclfProfile');
            Route::post('stage/{profile}/{stage}', 'CLFProfileController@profilesave');
            Route::get('/get-shg-data', 'CLFProfileController@get_shg_data'); 
            Route::get('/get-shg-datas', 'CLFProfileController@get_shg_datas'); 
            Route::get('/get-ec', 'CLFProfileController@get_ec'); 
            Route::get('/get-office-bearers', 'CLFProfileController@get_office_bearers'); 
            Route::get('/get-shg-member-datas', 'CLFProfileController@get_shg_member_datas'); 
            Route::post('/map-shg-data', 'CLFProfileController@map_shg_data'); 
            Route::get('/deceased', 'CLFProfileController@indexDeleted');
            Route::get('open-balance/', 'CLFProfileController@openbalance');
            Route::post('open-balance/update/{profile}', 'CLFProfileController@openbalanceupdate');
            Route::get('open-balance/edit/{profile}', 'CLFProfileController@openbalanceedit');
            Route::get('list-banks/{profile}', 'CLFProfileController@list_banks');
            Route::get('bank_profile/{profile}', 'CLFProfileController@addBankProfile');
            Route::get('check-ifsc/{ifsc}', 'CLFProfileController@checkifsc');
            Route::get('get-branches/{bank}', 'CLFProfileController@getbranches');
            Route::get('fetch-bank-account/{profile}', 'CLFProfileController@getbank');
//search
            Route::get('/search', 'CLFProfileController@searchUser');


            Route::get('/deleted/fetch', 'CLFProfileController@getAllDeletedUser');

            Route::get('/approved', 'CLFProfileController@indexInactive');
            Route::get('/in_active/fetch', 'CLFProfileController@getAllInactiveUser');


            Route::get('/create', 'CLFProfileController@create');
            Route::post('store', 'CLFProfileController@store');
            Route::get('view/{user}', 'CLFProfileController@view');
            Route::post('update/{user}', 'CLFProfileController@update');
            Route::get('approve/{user}', 'CLFProfileController@approve');
            Route::get('confirm/{user}', 'CLFProfileController@confirm');
            Route::get('send-cred/{user}', 'CLFProfileController@send_cred');
            
            Route::get('toggle_status/{user}', 'CLFProfileController@toggleStatus');
            Route::get('delete/{user}', 'CLFProfileController@delete');
            Route::get('get-banks/{bankdetails}', 'CLFProfileController@get_bank');
        });
         Route::prefix('plf-profile')->group(function () {
            Route::get('/', 'PLFProfileController@index'); 
            Route::get('/get-shg-data', 'PLFProfileController@get_shg_data'); 
            Route::get('/get-shg-datas', 'PLFProfileController@get_shg_datas'); 
            Route::get('/get-ec', 'PLFProfileController@get_ec'); 
            Route::get('/get-office-bearers', 'PLFProfileController@get_office_bearers'); 
            Route::get('/get-shg-member-datas', 'PLFProfileController@get_shg_member_datas'); 
            Route::post('/map-shg-data', 'PLFProfileController@map_shg_data'); 
            Route::get('/deceased', 'PLFProfileController@indexDeleted');
            Route::get('/fetch', 'PLFProfileController@getAllUser');
            Route::get('vo_profile/{profile}', 'AdminController@viewvoProfile');
            Route::get('open-balance/', 'PLFProfileController@openbalance');
            Route::post('open-balance/update/{profile}', 'PLFProfileController@openbalanceupdate');
            Route::get('open-balance/edit/{profile}', 'PLFProfileController@openbalanceedit');
            Route::get('list-banks/{profile}', 'PLFProfileController@list_banks');
            Route::get('bank_profile/{profile}', 'PLFProfileController@addBankProfile');
            Route::get('check-ifsc/{ifsc}', 'PLFProfileController@checkifsc');
            Route::get('get-branches/{bank}', 'PLFProfileController@getbranches');
            Route::get('get-sc/{profile}', 'PLFProfileController@getsc');
            Route::get('fetch-bank-account/{profile}', 'PLFProfileController@getbank');
            Route::post('stage/{profile}/{stage}', 'PLFProfileController@profilesave');

//search
            Route::get('/search', 'PLFProfileController@searchUser');


            Route::get('/deleted/fetch', 'PLFProfileController@getAllDeletedUser');

            Route::get('/approved', 'PLFProfileController@indexInactive');
            Route::get('/in_active/fetch', 'PLFProfileController@getAllInactiveUser');


            Route::get('/create', 'PLFProfileController@create');
            Route::post('store', 'PLFProfileController@store');
            Route::get('view/{user}', 'PLFProfileController@view');
            Route::post('update/{user}', 'PLFProfileController@update');
            Route::get('approve/{user}', 'PLFProfileController@approve');
            Route::get('confirm/{user}', 'PLFProfileController@confirm');
            Route::get('send-cred/{user}', 'PLFProfileController@send_cred');
            
            Route::get('toggle_status/{user}', 'PLFProfileController@toggleStatus');
            Route::get('delete/{user}', 'PLFProfileController@delete');
        });
        Route::prefix('plf-profile')->group(function () {
            Route::get('/', 'PLFProfileController@index'); 
            Route::get('/get-shg-data', 'PLFProfileController@get_shg_data'); 
            Route::get('/get-shg-datas', 'PLFProfileController@get_shg_datas'); 
            Route::get('/get-ec', 'PLFProfileController@get_ec'); 
            Route::get('/get-office-bearers', 'PLFProfileController@get_office_bearers'); 
            Route::get('/get-shg-member-datas', 'PLFProfileController@get_shg_member_datas'); 
            Route::post('/map-shg-data', 'PLFProfileController@map_shg_data'); 
            Route::get('/deceased', 'PLFProfileController@indexDeleted');
            Route::get('/fetch', 'PLFProfileController@getAllUser');
            Route::get('vo_profile/{profile}', 'AdminController@viewvoProfile');
            Route::get('bank-account/{profile}', 'PLFProfileController@viewBankProfile');
            Route::get('get-index-data/{profile}', 'PLFProfileController@get_index_data');
            Route::get('bank-account/fetch/{profile}', 'PLFProfileController@getbank_date');
            Route::get('get-banks/{bankdetails}', 'PLFProfileController@get_bank');
            Route::post('stage/{profile}/{stage}', 'PLFProfileController@profilesave');

//search
            Route::get('/search', 'PLFProfileController@searchUser');


            Route::get('/deleted/fetch', 'PLFProfileController@getAllDeletedUser');

            Route::get('/approved', 'PLFProfileController@indexInactive');
            Route::get('/in_active/fetch', 'PLFProfileController@getAllInactiveUser');


            Route::get('/create', 'PLFProfileController@create');
            Route::post('store', 'PLFProfileController@store');
            Route::get('view/{user}', 'PLFProfileController@view');
            Route::post('update/{user}', 'PLFProfileController@update');
            Route::get('approve/{user}', 'PLFProfileController@approve');
            Route::get('confirm/{user}', 'PLFProfileController@confirm');
            Route::get('send-cred/{user}', 'PLFProfileController@send_cred');
            
            Route::get('toggle_status/{user}', 'PLFProfileController@toggleStatus');
            Route::get('delete/{user}', 'PLFProfileController@delete');
        });
        Route::group(['prefix' => 'fund-type'], function () {
            Route::get('/', 'FundTypeController@index'); 
            Route::get('/deceased', 'FundTypeController@indexDeleted');
            Route::get('/fetch', 'FundTypeController@getAllUser');

//search
            Route::get('/search', 'FundTypeController@searchUser');


            Route::get('/deleted/fetch', 'FundTypeController@getAllDeletedUser');

            Route::get('/approved', 'FundTypeController@indexInactive');
            Route::get('/in_active/fetch', 'FundTypeController@getAllInactiveUser');


            Route::get('/create', 'FundTypeController@create');
            Route::post('store', 'FundTypeController@store');
            Route::get('view/{user}', 'FundTypeController@view');
            Route::post('update/{user}', 'FundTypeController@update');
            Route::get('approve/{user}', 'FundTypeController@approve');
            Route::get('confirm/{user}', 'FundTypeController@confirm');
            Route::get('send-cred/{user}', 'FundTypeController@send_cred');
            
            Route::get('toggle_status/{user}', 'FundTypeController@toggleStatus');
            Route::get('delete/{user}', 'FundTypeController@delete');
        });
        // Route::group(['prefix' => 'admins',  'middleware' => 'permission:admin'], function () {
            Route::group(['prefix' => 'admins'], function () {
            // prefix('admins')->group(function () {
            Route::get('/', 'AdminController@index');
            Route::get('/fetch', 'AdminController@getAllAdmin');
            Route::get('/create', 'AdminController@create');
            Route::post('store', 'AdminController@store');
            Route::get('edit/{admin}', 'AdminController@getById');
            Route::post('update/{admin}', 'AdminController@update');
            Route::get('toggle_status/{user}', 'AdminController@toggleStatus');
            Route::get('delete/{user}', 'AdminController@delete');
            Route::get('profile/{user}', 'AdminController@viewProfile');
            Route::get('clf_profile/{user}', 'AdminController@viewclfProfile'); 
            Route::post('profile/update/{user}', 'AdminController@updateProfile');
        }); 

 

        Route::group(['prefix' => 'users',  'middleware' => 'permission:user-menu'], function () {
            // prefix('users')->group(function () {
            Route::get('/', 'UserController@index');
            Route::get('/deceased', 'UserController@indexDeleted');
            Route::get('/fetch', 'UserController@getAllUser');

//search
            Route::get('/search', 'UserController@searchUser');


            Route::get('/deleted/fetch', 'UserController@getAllDeletedUser');

            Route::get('/approved', 'UserController@indexInactive');
            Route::get('/in_active/fetch', 'UserController@getAllInactiveUser');


            Route::get('/create', 'UserController@create');
            Route::post('store', 'UserController@store');
            Route::get('view/{user}', 'UserController@view');
            Route::post('update/{user}', 'UserController@update');
            Route::get('approve/{user}', 'UserController@approve');
            Route::get('confirm/{user}', 'UserController@confirm');
            Route::get('send-cred/{user}', 'UserController@send_cred');
            
            Route::get('toggle_status/{user}', 'UserController@toggleStatus');
            Route::get('delete/{user}', 'UserController@delete');
            // Route::get('/request-list/{user}', 'UserController@UserTripRequest');
            // Route::get('request-list/{user}', 'UserController@UserTripRequest');
            // Route::get('request-list/{user}/fetch', 'UserController@UserTripRequestView');
            Route::get('payment-history/{user}', 'UserController@userPaymentHistory');
            Route::post('payment-history/{user}', 'UserController@StoreUserPaymentHistory');  
            Route::post('/import-user', 'UserController@importUser'); 
            Route::get('/download', 'UserController@downloadFile');      
        Route::get('request-list/{user}', 'UserController@UserTripRequestIndex');
        Route::get('request-list/{user}/fetch', 'UserController@UserTripRequestNew');


        Route::get('cancellation-wallet/{user}', 'UserController@UserCancelRequestIndex');

        });
        Route::get('users/{user}/{payment_link}', 'UserController@payment_link');
        Route::group(['prefix' => 'sos',  'middleware' => 'permission:view-sos'], function () {
            Route::get('/', 'SosController@index');
            Route::get('/fetch', 'SosController@getAllSos');
            Route::get('/create', 'SosController@create');
            Route::post('store', 'SosController@store');
            Route::get('/{sos}', 'SosController@getById');
            Route::post('update/{sos}', 'SosController@update');
            Route::get('toggle_status/{sos}', 'SosController@toggleStatus');
            Route::get('delete/{sos}', 'SosController@delete');
        });     
     
    //purchaseCode 
        Route::group(['prefix' => 'purchasecode'], function () {
        Route::get('/', 'PurchaseCodeController@index');
        Route::post('/verification', 'PurchaseCodeController@verifyPurchasecode');  

        });

    });

    Route::namespace('Master')->group(function () {

        Route::prefix('roles')->group(function () {
            Route::get('/', 'RoleController@index');
            Route::get('create', 'RoleController@create');
            Route::post('store', 'RoleController@store');
            Route::get('/fetch', 'RoleController@fetch');
            Route::get('edit/{id}', 'RoleController@getById');
            Route::post('update/{role}', 'RoleController@update');
            Route::get('assign/permissions/{id}', 'RoleController@assignPermissionView');
            Route::post('assign/permissions/update/{role}', 'RoleController@attachAndDetachPermissions');
        });
        Route::prefix('system/settings')->group(function () {
            Route::get('/', 'SettingController@index');
            Route::post('/', 'SettingController@store');
        });

        // Car Make CRUD
        Route::group(['prefix' => 'carmake',  'middleware' => 'permission:manage-carmake'], function () {
            Route::get('/', 'CarMakeController@index');
            Route::get('/fetch', 'CarMakeController@fetch');
            Route::get('/create', 'CarMakeController@create');
            Route::post('store', 'CarMakeController@store');
            Route::get('/{make}', 'CarMakeController@getById');
            Route::post('update/{make}', 'CarMakeController@update');
            Route::get('toggle_status/{make}', 'CarMakeController@toggleStatus');
            Route::get('delete/{make}', 'CarMakeController@delete');
        });

        // Car Model CRUD
        Route::group(['prefix' => 'carmodel',  'middleware' => 'permission:manage-carmodel'], function () {
            Route::get('/', 'CarModelController@index');
            Route::get('/fetch', 'CarModelController@fetch');
            Route::get('/create', 'CarModelController@create');
            Route::post('store', 'CarModelController@store');
            Route::get('/{model}', 'CarModelController@getById');
            Route::post('update/{model}', 'CarModelController@update');
            Route::get('toggle_status/{model}', 'CarModelController@toggleStatus');
            Route::get('delete/{model}', 'CarModelController@delete');
        });

            // Countries CRUD
            Route::group(['prefix' => 'country',  'middleware' => 'permission:manage-country'], function () {
                Route::get('/', 'CountryController@index');
                Route::get('/fetch', 'CountryController@fetch');
                Route::get('/create', 'CountryController@create');
                Route::post('store', 'CountryController@store');
                Route::get('/{country}', 'CountryController@getById');
                Route::post('update/{country}', 'CountryController@update');
                Route::get('toggle_status/{country}', 'CountryController@toggleStatus');
                Route::get('delete/{country}', 'CountryController@delete');
            });

        // Driver Needed Document CRUD
        Route::group(['prefix' => 'needed_doc',  'middleware' => 'permission:manage-driver-needed-document'], function () {
            Route::get('/', 'DriverNeededDocumentController@index');
            Route::get('/fetch', 'DriverNeededDocumentController@fetch');
            Route::get('/create', 'DriverNeededDocumentController@create');
            Route::post('store', 'DriverNeededDocumentController@store');
            Route::get('/{needed_doc}', 'DriverNeededDocumentController@getById');
            Route::post('update/{needed_doc}', 'DriverNeededDocumentController@update');
            Route::get('toggle_status/{needed_doc}', 'DriverNeededDocumentController@toggleStatus');
            Route::get('delete/{needed_doc}', 'DriverNeededDocumentController@delete');
        }); 
         // Owner Needed Document CRUD
                Route::group(['prefix' => 'owner_needed_doc',  'middleware' => 'permission:manage-owner-needed-document'], function () {
                    Route::get('/', 'OwnerNeededDocumentController@index');
                    Route::get('/fetch', 'OwnerNeededDocumentController@fetch');
                    Route::get('/create', 'OwnerNeededDocumentController@create');
                    Route::post('store', 'OwnerNeededDocumentController@store');
                    Route::get('/{needed_doc}', 'OwnerNeededDocumentController@getById');
                    Route::post('update/{needed_doc}', 'OwnerNeededDocumentController@update');
                    Route::get('toggle_status/{needed_doc}', 'OwnerNeededDocumentController@toggleStatus');
                    Route::get('delete/{needed_doc}', 'OwnerNeededDocumentController@delete');
                }); 
          // Fleet Needed Document CRUD
            Route::group(['prefix' => 'fleet_needed_doc',  'middleware' => 'permission:manage-fleet-needed-document'], function () {
                Route::get('/', 'FleetNeededDocumentController@index');
                Route::get('/fetch', 'FleetNeededDocumentController@fetch');
                Route::get('/create', 'FleetNeededDocumentController@create');
                Route::post('store', 'FleetNeededDocumentController@store');
                Route::get('/{needed_doc}', 'FleetNeededDocumentController@getById');
                Route::post('update/{needed_doc}', 'FleetNeededDocumentController@update');
                Route::get('toggle_status/{needed_doc}', 'FleetNeededDocumentController@toggleStatus');
                Route::get('delete/{needed_doc}', 'FleetNeededDocumentController@delete');
                }); 
        // Package type CRUD
        Route::group(['prefix' => 'package_type',  'middleware' => 'permission:package-type'], function () {
            Route::get('/', 'PackageTypeController@index');
            Route::get('/fetch', 'PackageTypeController@fetch');
            Route::get('/create', 'PackageTypeController@create');
            Route::post('store', 'PackageTypeController@store');
            Route::get('/{package}', 'PackageTypeController@getById');
            Route::post('update/{package}', 'PackageTypeController@update');
            Route::get('toggle_status/{package}', 'PackageTypeController@toggleStatus');
            Route::get('delete/{package}', 'PackageTypeController@delete');
        });
         // OTP  CRUD
                Route::group(['prefix' => 'otp',  'middleware' => 'permission:otp'], function () {
                    Route::get('/', 'OtpController@index');
                    Route::get('/fetch', 'OtpController@fetch');        
                }); 
        
    });
});

Route::middleware('auth:web')->namespace('Dispatcher')->group(function () {
    Route::prefix('dispatch')->group(function () {
    Route::get('/new', 'DispatcherController@dispatchView');
    Route::get('/', 'DispatcherController@index');
    Route::post('/create/request', 'DispatcherController@createRequest');
    Route::get('/request/{requestmodel}', 'DispatcherController@fetchSingleRequest');
    Route::get('cancel-requests/{request}', 'DispatcherController@cancelledrequest');

    
    Route::get('/requests-list', 'DispatcherController@requestView');
    Route::get('/request_fetch', 'DispatcherController@fetch');
   
    Route::get('/book-ride', 'DispatcherController@book_Now');
    Route::get('/ongoing-trip', 'DispatcherController@ongoingTrip');
    Route::get('/detailed-view/{requestmodel}', 'DispatcherController@detailView');
    Route::get('/dispatch-new/later', 'DispatcherController@bookLater');
    Route::get('/header', 'DispatcherController@header');

});

// Route::view('/dispatch-new', '/dispatch-new.home');
Route::view('/requests-list', '/dispatch-new.requests-list');
//    Route::view('/login-dispatch', '/dispatch-new.login');
Route::view('/d', '/dispatch-new.d');

// Route::view('/login-dispatch', '/dispatch-new.login');

Route::get('/book-ride', 'DispatcherController@book_ride');
Route::get('adhoc-list-packages','DispatcherController@listPackages');
Route::get('check-user-exist','DispatcherController@checkuserexist');
Route::get('/assign-driver/{request}','DispatcherController@assigndriver');
Route::get('/assign-manual/{request_detail}','DispatcherController@assigmanual');
// Route::view('/book-ride', '/dispatch-new.book-ride');
Route::get('/ongoing-trip', 'DispatcherController@ongoingTrip');

// Route::view('/detailed-view', '/dispatch-new.detailed-view');
Route::view('/dispatch-new/later', '/dispatch-new.book-later');
Route::view('/assign-driver', '/dispatch-new.assign-driver');
Route::view('/header', '/dispatch-new.header');

Route::view('/owner-dashboard', '/owner.home');
Route::view('/owner-driver', '/owner.drivers');
// Route::view('/owner-fleets', '/owner.fleets');
// Route::view('/add-fleet', '/owner.add-fleet');
});


Route::middleware('auth:web')->namespace('owner')->group(function () {
    Route::get('/owner-fleets', 'FleetController@viewFleet');
    Route::get('/add-fleet', 'FleetController@addFleet');
}); 



