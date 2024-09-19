<?php

use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/pusher',function(){
       return view('pusher');
});

Route::namespace('Frontend')->group(function() {
    Route::controller('FrontendController')->name('frontend.')->group(function() {
        Route::get('/','index')->name('index');
        Route::get('/about-us','aboutUs')->name('abouts');
        Route::get('/about-us','aboutUs')->name('abouts');
        Route::get('/property-listing','propertyListing')->name('property.listing');
        Route::get('/contact-us','contactUs')->name('contact.us');
        Route::get('/list-our-property','listOurProperty')->name('list.our.property');
        Route::post('/sugesstion-destination','destintaionSuggestion')->name('destination.suggestion');
        Route::get('/partner-listing','partnerListing')->name('partner.listing');
        Route::post('/calender','calender');
        Route::get('/property/ical-link/{id}','genratePropertIcalLink');
    });
    Route::controller('PropertyListingController')->group(function () {
        Route::get('/property-details/p{id}','propertyListingDetails')->name("property.listing.details");
        Route::get('/location-property','locationProperty')->name('location.property');
        Route::post('/property-enquiry-store','propertyEnquiryStore')->middleware('check-user-loggedin');
        Route::post('/store-reviews-rating','StoreReviewsRating');
        Route::post('/calculte-rate','calculateRate')->name('calculate.rate');
    });

    Route::controller('AuthController')->middleware(['back-prevent-history','guest'])->prefix('auth')->group(function() {
        Route::post('owner-register','OwnerRegistration')->name('owner.registration');
        Route::post('owner-login','ownerLogin');
    });

    // Booking Route

    Route::controller(BookingInformationController::class)->group(function () {
        Route::post('/store-booking-information','storeBookingInformation')->middleware('check-user-loggedin');
        Route::get('/booking-information','bookingInformation')->name('booking.information');
        Route::post('/make-payment','makePayment')->name('make.paymnet');
        Route::get('/payment-success', function () {
            return view('frontend.payment-success');
        })->name('payment.success');
        Route::get('/payment-failed', function () {
            return view('frontend.payment-error');
        })->name('payment.failed');
    });

    Route::controller(ChatController::class)->group(function(){
        Route::get('/chat','chat')->name('chat');
        Route::get('/get-user','getUser');
        Route::post('/insert-chat','InsertChat');
        Route::post('/get-chat','getChat');
        Route::get('/owner/chat/scheduled-message/{id}','scheduledMessage')->name('owner.chat.sheduled.message');
        Route::get('/owner/chat/edit-template','editTemplate')->name('owner.chat.edit.template');
        Route::get('/owner/chat/scheduled-message/listing/{id}','templateListing')->name('owner.chat.sheduled.message.listing');
        Route::get('/owner/chat/quick-replies','quickReplies')->name('owner.chat.quick-replies');
        Route::get('/owner/chat/create-template/{user_id}','createTemplate')->name('owner.chat.create.template');
        Route::POST('/owner/chat/delete-template','destroy')->name('owner.chat.delete.template');
        Route::post('/owner/chat/template-store','store')->name('owner.chat.template.stote');
    });

    Route::controller(CancelBookingController::class)->prefix('cancel-booking')->group(function(){
        Route::get('cancel/{cancel_id}','cancelBooking')->name('cancel.booking');
        Route::post('/store','cancelBookingStore')->name('cancel.booking.store');
        Route::get('/list','cancelBookingList')->name('cancel.bokking.list');
    });
});
Route::namespace('Partner')->group(function() {
    Route::controller(DashboardController::class)->group(function(){
    Route::get('/partner/dashboard','dashboard')->name('partner.dashboard'); 
    Route::get('/partner/partner-listing/manage-paymanet','managePayment')->name('partner.manage.payment'); 
    Route::get('/partner/partner-listing/manage-partner-listing','managePartnerListing')->name('partner.manage.partner.listing');
    Route::get('/partner/add-partner-listing-payment','addPartnerListingPayment')->name('partner.add.partner.listing.payment');
    Route::post('/partner/store-partner-listing-payment','storePartnerPaymentListing')->name('partner.store.partner.listing.payment');
    Route::post('/make-partner-listing-paymnet','makePartnerListingPayment');
    Route::post('/partner/partner-listing/make-partner-listing-paymnet','makePartnerListingPayment');
    Route::get('/partner/create-partner-listing','createPartnerListing')->name('partner.create.partner.listing');
    Route::post('/partner/store-partner-listing','storePartnerListing')->name('partner.store.partner.listing');
    Route::post('/partner/partner-listing-delete','partnerListingDelete')->name('partner.partner.listing.delete');
    Route::get('/partner/partner-listing-edit/{id}','partnerListingEdit')->name('partner.edit.partner.listing');
    Route::post('/partner/update-partner-listing','updatePartnerListing')->name('partner.update.partner.listing');
    Route::post('/partner/delete-image-partner-listing-images','deleteImagePartnerListingImage')->name('partner.delete.image.partner.listing');
 });
});

