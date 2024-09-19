<?php
use Illuminate\Support\Facades\Route;

Route::namespace('Owner')->prefix('owner')->name('owner.')->middleware(['back-prevent-history','auth'])->group(function() {
    Route::controller('DashboardController')->group(function(){
        Route::get('/dashboard','index')->name('dashboard');
        Route::get('/logout','logout')->name('logout');
        Route::get('my-property-listing','myPropertyListing')->name('my.property.listing');
        Route::get('create-property/{id?}','createProperty')->name('create.property');
        Route::get('booking-request','bookingRequest')->name('booking.request');
        Route::get('/property-booking','propertyBooking')->name('property.booking');
        Route::get('/property-booking-details/{id}','propertyBookingDetails')->name('property.booking.details');
        Route::get('/chat','chat')->name('chat');
        Route::get('/cancel-booking','cancelBooking')->name('cancel.booking');
        Route::get('switch-to-traveller','switchToTraveller')->name('switch.to.traveller');
    });

    Route::controller('ProfileController')->group(function() {
        Route::get('billing-details','billingDetails')->name('billing.details');
        Route::post('billing-details-store','storeBillingDetails')->name('billing.details.store');
        Route::get('edit-profile','editProfile')->name('edit.profile');
        Route::post('store-profile','updateProfile')->name('store.profile');
    });

    Route::controller(PaymentController::class)->group(function() {
        Route::get('taransaction','transaction')->name('transaction');
        Route::get('add-feature-property','addFeatureProperty')->name('create.payment');
        Route::post('/calculate-price','calculatePrice');
        Route::post('make-payment','makePayment')->name('make.payment');
        Route::get('card-details','cardDetails')->name('card.details');
        Route::post('payment','payment')->name('payment');
    });

    // Email Template Route
    Route::controller(EmailTemplateController::class)->group(function() {
        Route::get('/payment-reminder','paymentReminder')->name('payment.reminder');
        Route::post('/store-paymnet-request','storePaymentRequest')->name('store.payment.request');
        Route::get('/cancellation-message','cancellationMessage')->name('cancellation.message');
        Route::post('/store-cancellation-message','storeCancellationMessage')->name('store.cancellation.message');
        Route::get('/welcome-message','welcomeMessage')->name('welcome.message');
        Route::post('/store-welcome-message','storeWelcomeMessage')->name('store.welcome.message');
        Route::get('invite-to-leave-a-review','inviteToLeaveAReview')->name('invite.to.leave.a.review');
        Route::post('/store-leave-to-leave-a-review','storeInviteToLeaveAReview')->name('store.invite.to.leave.a.review');
    });

    Route::controller(PartnerListingController::class)->prefix('partner-listing')->group(function() {
        Route::get('/add-partner-listing-payment','addPartnerListingPayment')->name('add.partner.listing.payment');
        Route::get('/manage-paymanet','managePayment')->name('manage.payment');
        Route::post('/store-partner-listing-payment','storePartnerPaymentListing')->name('store.partner.listing.payment');
        Route::post('/make-partner-listing-paymnet','makePartnerListingPayment');
        Route::get('/manage-partner-listing','managePartnerListing')->name('manage.partner.listing');
        Route::get('/create-partner-listing','createPartnerListing')->name('create.partner.listing');
        Route::post('/store-partner-listing','storePartnerListing')->name('store.partner.listing');
        Route::post('/partner-listing-delete','partnerListingDelete')->name('partner.listing.delete');
        Route::get('/partner-listing-edit/{id}','partnerListingEdit')->name('edit.partner.listing');
        Route::post('/update-partner-listing','updatePartnerListing')->name('update.partner.listing');
        Route::post('/delete-image-partner-listing-images','deleteImagePartnerListingImage')->name('delete.image.partner.listing');
    });
});