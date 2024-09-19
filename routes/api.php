<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::controller(FrontendController::class)->group(function() {
    Route::get('/property-listing','propertyListing');
    Route::get('/property-details/{id}','propertyDetails');
    Route::post('/booking-get-quote','bookingGetQoute');
    Route::get('/partner-listing','partnerListing');
});

 Route::controller(ChatController::class)->group(function (){
      // Route::post('/message-show','show');
    Route::post('/insert-chat','InsertChat');
    Route::post('/chat-list','ChatList');
    Route::post('/get-user','getUser');
    Route::post('/get-chat','getChat');
});

Route::controller(CommonController::class)->group(function(){
    Route::get('/get-role','getRole');
    Route::get('/property-types','propertyTypes');
    Route::get('/dashboard-property-types','dashboardPropertyTypes');
    Route::get('/country','country');
    Route::get('/state','state');
    Route::get('/region','region');
    Route::get('/city','city');
    Route::get('/sub-city','subCity');
    Route::get('/amenities','amenities');
    Route::get('/currency','currency');
    Route::get('/cancellention-policies','cancellentionPolicies');
    Route::get('/destination-list','destinationList');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/registration','registration');
    Route::post('/login','login');
    Route::post('/forget-password-send-link','sendForgetPasswordLink')->name('send.forget.password.link');
});

Route::middleware('auth:api')->group(function() {
    Route::controller(Dashboard::class)->group(function() {
        Route::get('/logout','logout');
        Route::post('/change-user-type','changeUserType');
        Route::post('/change-password','changePassword');
        Route::post('/get-calander-data','getCalanderData');
    });
    Route::controller(PropertyController::class)->prefix('property')->group(function(){
        Route::post('/property-information','propertyInformation');
        Route::post('store-amenities','storeAmenities');
        Route::post('/location-store','locationStore');
        Route::post('/rental-rates-store','rentalRatesStore');
        Route::post('/additional-rental-rates','additionalRatesStore');
        Route::post('/gallery-images','galleryImages');
        Route::post('/rental-policies','rentalPolicies');
        Route::post('/calender-syncronized','calenderSynchronization');
        Route::post('/reviews','reviews');
        Route::post('/add-wishlist','addWishList');
        Route::post('/remove-wishlist','removeWishList');
        Route::get('/wishlist','wishList');
        Route::get('/get-property-information/{id}','getPropertyInformation');
        Route::post('/update-property-information','updatePropertyInformation');
        Route::get('/property-list','propertyList');
        Route::post('/add-gallery-image','addGalleryImage');
        Route::post('delete-gallery-image','deleteGalleryImage');
    });

    Route::controller(ProfileController::class)->group(function() {
        Route::post('/billing-details','billingDetails');
        Route::get('/get-owner-billing-details','getOwnerBillingDetails');
        Route::post('/update-owner-profile','updateOwnerProfile');
        Route::get('/get-owner-profile-details','getOwnerProfileDetails');
        Route::post('/update-owner-billing-deatils','updateOwnerBillingDetails');
    });

    Route::controller(BookingInformationController::class)->group(function() {
        Route::post('/save-booking-details','storeBookingDetails');
        Route::get('/my-booking-list','myBookingList');
        Route::get('/booking-details/{id}','bookingDetails');
        Route::post('/pay-remening-balance','payRemeningBalance');
        Route::get('/transaction-history','transactionHistory');
    });

    Route::controller(CancelBookingController::class)->group(function() {
        Route::get('/cancellention-reason-list','cancellentionReasonList');
        Route::post('/cancel-booking','cancelBooking');
        Route::get('/cancel-booking-list','cancelBookingList');
    });

    Route::controller(FeatureListingController::class)->group(function() {
        Route::post('/create-feature-listing','createFeatureListing');
        Route::post('/make-payment-feature-listing-property','makePaymentFeatureListingProperty');
        Route::get('/feature-listing-property','featureListingPorperty');
    });

    Route::controller(PartnerListingController::class)->group(function () {
        Route::get('/create-partner-listing','createPartnerListing');
    });
});
