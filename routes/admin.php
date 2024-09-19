<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

/* 
Admin Auth Route start

 */
Route::controller(AuthController::class)->middleware(['back-prevent-history','guest'])->group(function () {
    Route::get('/','index')->name('login');
    Route::post('login','doLogin')->name('check.creditials');
    Route::get('/forget-password','forgetPassword')->name('forget.password');
    Route::post('/forget-password-send-link','sendForgetPasswordLink')->name('send.forget.password.link');
    Route::get('reset-password/{token}','resetPassword')->name('reset.password.get');
    Route::post('/password-reset','passwordReset')->name('password.reset');
});

/* 
Admin Auth Route end
 */
/* 
 Admin Before Login Rote Start 
 */
Route::middleware(['back-prevent-history','auth'])->group(function () {

    Route::controller(DashboardController::class)->group(function() {
        Route::get('dashboard','index')->name('dashboard');
        Route::get('edit-profile','editProfile')->name('edit.profile');
        Route::post('store-profile','updateProfile')->name('store.profile');
        Route::get('logout','logout')->name('logout');
    });

    // Admin Master Route 
    Route::controller(AminitiesController::class)->prefix('aminities')->name('master.')->group(function () {
        /* 
        Main Aminity Route start
        */
        Route::get('manage-main-aminity','manageMainAminity')->name('manage.main.aminity');
        Route::get("get-aminites-using-datatables","getAmenitesUsingDatatble")->name('get.aminites.using.datatables');
        Route::get('create-main-aminity','createMainAminty')->name('create.main.aminity');
        Route::post('store-main-aminity','storeMainAminity')->name('store.main.aminity');
        Route::post('delete-main-aminities','DeleteMAinAminity')->name('delete.main.aminities');
        Route::get("edit-main-aminities/{id}",'editMainAminity')->name('edit.main.aminities');
        Route::post('update-main-aminities','updateMainAminities')->name('update.main.aminities');
         /* 
        Main Aminity Route end
        */

        /* 
        Sub Aminity Route start
        */
        Route::get('manage-sub-aminity','manageSubAminity')->name('manage.sub.aminity');
        Route::get("get-sub-aminites-using-datatables","getSubAmenitesUsingDatatble")->name('get.sub.aminites.using.datatables');
        Route::get('create-sub-aminity','createsubAminty')->name('create.sub.aminity');
        Route::post('store-sub-aminities','storeSubAminity')->name('store.sub.aminities');
        Route::post('delete-sub-aminities','DeleteSubAminity')->name('delete.sub.aminities');
        Route::get("edit-sub-aminities/{id}",'editSubAminity')->name('edit.sub.aminities');
        Route::post('update-sub-aminities','updateSubAminities')->name('update.sub.aminities');
        /* 
        Sub Aminity Route end
        */
    });

    /* 
        Loaction Route Start
    */
    Route::controller(LocationController::class)->prefix('location')->name('location.')->group(function () {
        /* 
            Country Route Start 
        */
            Route::get('country','country')->name('country');
            Route::get('country-create','countryCreate')->name('country.create');
            Route::post('country-store','countryStore')->name('country.store');
            Route::get('country-edit/{id}','countryEdit')->name('country.edit');
            Route::post('country-update','countryUpdate')->name('country.update');
            Route::post('country-delete','countryDelete')->name('country.delete');
        /* 
            Country Route End
        */
        /* 
            State State Start 
        */
            Route::get('state','state')->name('state');
            Route::get('state-create','stateCreate')->name('state.create');
            Route::post('state-store','stateStore')->name('state.store');
            Route::get('state-edit/{id}','stateEdit')->name('state.edit');
            Route::post('state-update','stateUpdate')->name('state.update');
            Route::post('state-delete','stateDelete')->name('state.delete');
            Route::post('get-state-by-country-id','getStateByCountryId');
        /* 
            State Route End
        */

        /* 
            Region Route Start 
        */
            Route::get('region','region')->name('region');
            Route::get('region-create','regionCreate')->name('region.create');
            Route::post('region-store','regionStore')->name('region.store');
            Route::get('region-edit/{id}','regionEdit')->name('region.edit');
            Route::post('region-update','regionUpdate')->name('region.update');
            Route::post('region-delete','regionDelete')->name('region.delete');
            // Route::post('get-region-by-state-id','getRegionByStateId');
        /* 
            Region Route End
        */

        /* 
            City Route Start 
        */
        Route::get('city','city')->name('city');
        Route::get('city-create','cityCreate')->name('city.create');
        Route::post('city-store','cityStore')->name('city.store');
        Route::get('city-edit/{id}','cityEdit')->name('city.edit');
        Route::post('city-update','cityUpdate')->name('city.update');
        Route::post('city-delete','cityDelete')->name('city.delete');
        
    /* 
        City Route End
    */
        /* 
            Cities Route Start 
        */
        Route::get('cities','cities')->name('cities');
        Route::get('cities-create','citiesCreate')->name('cities.create');
        Route::post('cities-store','citiesStore')->name('cities.store');
        Route::get('cities-edit/{id}','citiesEdit')->name('cities.edit');
        Route::post('cities-update','citiesUpdate')->name('cities.update');
        Route::post('cities-delete','citiesDelete')->name('cities.delete');
        
    /* 
        Cities Route End
    */
        
    });
    /* 
        Loaction Route End
    */

    // Property Listing Route Start
    Route::controller(PropertyListingController::class)->prefix('property-listing')->name('property.listing.')->group(function () {
        Route::get('/','index')->name('index');
        Route::get('/create/{id?}','create')->name('create');
        Route::post('/store','store')->name('store');
        Route::post('/store-step2','stepTwoStore')->name('step.two.store');
        Route::post('/property-rates-store','propertyRateStore')->name('property.rates.store');
        Route::get('/get-property-rates','getPropertyRates');
        Route::post('/store-rental-rates','rentalRatesStore');
        Route::post('/store-rental-rates','rentalRatesStore');
        Route::post('/store-gallery-image','galleryImageStore');
        Route::post("location-info-store",'locationInfoStore');
        Route::post("store-rental-policies",'rentalPolicyStore');
        Route::post("calender-synchronization",'calenderSynchronization');
        Route::get('get-reviews-rating','getReviewsRating');
        Route::post('/store-reviews-rating','storeReviewsRating');
        Route::post('/store-owner_information','storeOwnerInformation');
        Route::post('/get-rental-rates','getRentalRates');
        Route::post('/update-rental-rates','UpdateRentalRates');
        Route::post('/delete-rental-rates','deleteRentalRates');
        Route::post('/delete-property','deleteProperty')->name("delete.propert");
        Route::post('/property-approval','propertyApproval')->name("approval.property");
        Route::post('/property-feature','propertyFeature')->name("feature.property");
        Route::post('reviews-rates-get-by-id','reviewsRatesGet');
        Route::post('reviews-rating-update','reviewsRatingUpdate');
        Route::post('reviews-rating-delete','reviewsRatingDelete');
        Route::post('/get-property-event','getPropertyEvent')->name('get.property.event');
        Route::post('/delete-property-image','deletePropertyImage');
        Route::post('/get-property-gallery-image','getPropertyGalleryImaage');
        Route::post('/update-gallery-image-order','updateGalleryImageOrder');
        Route::post('/block-manual-booking','blockManualBooking')->name('block.manual.booking');
        Route::post('/rate-manual-booking','rateManualBooking')->name('rate.manual.booking');
        Route::post('/un-block-manual-booking','unBlockManualBooking')->name('unblock.manual.booking');
       
    });
    // Property Listing Route End
    Route::controller(UserManagementController::class)->group(function(){
        Route::get('user-management','userMangement')->name('user.management');
        Route::get('manage-owner-billing-detail','OwnerBillingAdress')->name('manage.owner.billing.detail');
        Route::post('change-user-status','changeUserStatus')->name('change.user.status');
        Route::get('owner-subscription','ownerSubscription')->name('owner.subscription');
        Route::get('/property-booking-list','propertyBookingList')->name('property.booking_details');
        Route::get('property-booking-details/{id}', 'propertyBookingDetails')->name('property.booking.details');
    });

    // Partner Listing Route
    Route::controller(PartnerListingController::class)->prefix('partner-listing')->name('partner.listing.')->group(function() {
        Route::get('/manage-payments','managePayment')->name('manage.payment');
        Route::get('/manage-listing','manageListing')->name('manage.listing');
    });

    // Cancel Booking Route
    Route::controller(CancelBookingController::class)->prefix('cancel-booking')->name('cancel.booking.')->group(function() {
        Route::get('/list','cancelBookingList')->name('list');
    });

    // Email template Route 
    Route::controller(EmailTemplateController::class)->prefix('email-template')->name('email.template.')->group(function() {
        Route::get('payment-reminder','paymentReminder')->name('payment.reminder');
        Route::post('/store-paymnet-request','storePaymentRequest')->name('store.payment.request');
        Route::get('/cancellation-message','cancellationMessage')->name('cancellation.message');
        Route::post('/store-cancellation-message','storeCancellationMessage')->name('store.cancellation.message');
        Route::get('/welcome-message','welcomeMessage')->name('welcome.message');
        Route::post('/store-welcome-message','storeWelcomeMessage')->name('store.welcome.message');
        Route::get('invite-to-leave-a-review','inviteToLeaveAReview')->name('invite.to.leave.a.review');
        Route::post('/store-leave-to-leave-a-review','storeInviteToLeaveAReview')->name('store.invite.to.leave.a.review');

    });
    //Tax Route
      Route::controller(TaxController::class)->prefix('tax')->name('tax.')->group(function(){
        Route::get('list','list')->name('list');
        Route::get('create','create')->name('create');
        Route::post('store','store')->name('store');
        Route::get('edit/{id}','edit')->name('edit');
        Route::post('update','update')->name('update');
        Route::post('delete','destroy')->name('delete');
     });
     // Insurance
      Route::controller(InsuranceController::class)->prefix('insurance')->name('insurance.')->group(function(){
        Route::get('list','list')->name('list');
        Route::post('export','export')->name('export');
       Route::post('delete','destroy')->name('delete');
    });
});

    Route::controller(LocationController::class)->prefix('location')->group(function(){
        Route::post('get-region-by-state-id','getRegionByStateId');
        Route::post('get-city-by-region-id','getCityByRegionId');
        Route::post('get-sub-city-by-city-id','getSubCityByCityId');
    });

    Route::get('/ip',function (){
        dd(Request::ip(),$_SERVER);
    });

/* 
 Admin Before Login Rote end 
 */