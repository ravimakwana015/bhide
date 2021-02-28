<?php

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

Route::get('/', 'HomeController@home')->name('landing.page');
Auth::routes(['register' => false]);

Route::get('payment-details/{id}', 'SubscriptionPaymentController@paymentDetails')->name('payment.details');
Route::get('payment/{id}', 'SubscriptionPaymentController@Payment')->name('payment');
Route::post('order-post', 'SubscriptionPaymentController@orderPost')->name('order-post');
Route::get('thank-you', 'SubscriptionPaymentController@thankYou')->name('thank.you');
Route::get('features', 'HomeController@features')->name('user.features');

Route::post('/loginuser', 'Auth\LoginController@login')->name('login.user');
// Dynamic Routes
Route::get('/contact-us', 'HomeController@contact')->name('user.contactus');
Route::post('/contact-us/store', 'HomeController@contactstore')->name('contactus.store');
Route::get('/pages/{slug}', 'HomeController@dynamicPage')->name('user.dynamicPage');

Route::get('/t', function () {
    event(new \App\Events\SendMessage());
    dd('Event Run Successfully.');
});
Route::get('messages', 'MessagesController@index');
Route::post('messages', 'MessagesController@sendMessage');

// Route::post('stripe/webhook', '\App\Http\Controllers\WebhookController@handleWebhook');
Route::group(
    ['middleware' => 'auth'],
    function () {
        Route::get('/dashboard', 'HomeController@index')->name('home');
        // Route::get('/dashboard', 'HomeController@dashboard')->name('user.dashboard');
        Route::post('/send-emergency-alarm', 'HomeController@sendEmergencyAlarm')->name('send.emergency.alarm');

        Route::resources([
            'apartment' => 'Apartment\ApartmentUserController',
            'units' => 'Apartment\UnitsController',
            'services' => 'Services\ServicesController',
            'facilities' => 'Facilities\FacilitiesController',
            'visitors' => 'Visitors\VisitorsController',
            'concierges' => 'Concierges\ConciergesController',
            'messageBoard' => 'MessageBoard\MessageBoardController',
            'loyaltyCard' => 'LoyaltyCard\LoyaltyCardController',
            'polls' => 'Polls\PollsController',
            'parcels' => 'Parcels\ParcelsController',
            'emergency' => 'Emergency\EmergencyAlarmsResponseController',
            'companySettings' => 'CompanySettingsController',
            'issues' => 'UnitIssueRequest\UnitIssueRequestController',
        ]);
        Route::post('get-issues', 'UnitIssueRequest\UnitIssueRequestController@getIssues')->name('get.issues');

        Route::post('get-emergency-response', 'Emergency\EmergencyAlarmsResponseController@getEmergencyResponse')->name('get.emergency.response');

        Route::post('get-parcels', 'Parcels\ParcelsController@getParcels')->name('get.parcels');
        Route::post('get-parcels-details', 'Parcels\ParcelsController@getPollUsers')->name('get.parcels.details');

        Route::post('get-polls', 'Polls\PollsController@getPolls')->name('get.polls');
        Route::post('delete-option', 'Polls\PollsController@deleteOption')->name('delete.option');
        Route::post('get-poll-result', 'Polls\PollsController@getPollResult')->name('get.poll.result');
        Route::post('get-poll-users', 'Polls\PollsController@getPollUsers')->name('get.poll.users');


        Route::post('get-loyaltyCard', 'LoyaltyCard\LoyaltyCardController@getLoyaltyCard')->name('get.loyaltyCard');

        Route::post('get-messageBoard', 'MessageBoard\MessageBoardController@getMessageBoard')->name('get.messageBoard');

        Route::post('get-concierges', 'Concierges\ConciergesController@getConcierges')->name('get.concierges');
        Route::post('clock', 'Concierges\ConciergesController@clockTime')->name('clock');

        Route::post('get-visitors', 'Visitors\VisitorsController@getVisitors')->name('get.visitors');
        Route::post('visitor-checkout', 'Visitors\VisitorsController@visitorCheckout')->name('visitor.checkout');

        Route::get('get-gates', 'Visitors\VisitorsController@getGates')->name('get.gates');
        Route::post('add-gate', 'Visitors\VisitorsController@addGate')->name('add.gate');
        Route::get('get-reasons', 'Visitors\VisitorsController@getReasons')->name('get.reasons');
        Route::post('add-reason', 'Visitors\VisitorsController@addReason')->name('add.reason');

        Route::post('get-facilities', 'Facilities\FacilitiesController@getFacilities')->name('get.facilities');

        Route::post('get-services', 'Services\ServicesController@getServices')->name('get.services');

        Route::post('get-apartment-users', 'Apartment\ApartmentUserController@getUsers')->name('get.apartment.users');

        Route::post('get-user-units', 'Apartment\UnitsController@getUnits')->name('get.user.units');

        Route::get('send-login-details/{user_id}', 'Apartment\ApartmentUserController@sendLoginDetails')->name('send_login_details');

        Route::get('/profile-edit', 'ProfileController@edit')->name('edit');
        Route::post('/profile-update/{id}', 'ProfileController@update')->name('update');
        Route::post('upload-profile-pic', 'ProfileController@uploadBuildingIcon')->name('upload-profile-pic');
        Route::post('/dentist-upload-image', 'ProfileController@uploadImage')->name('upload-dentist-image');
        Route::get('/change-password', 'ProfileController@ChangePassword')->name('change.password');
        Route::post('/update-password', 'ProfileController@updatePassword')->name('update.password');

        Route::post('upload-concierges-pic', 'Concierges\ConciergesController@uploadConciergesIcon')->name('upload-concierges-pic');

        Route::post('upload-loyalty-pic', 'CompanySettingsController@uploadLoyaltyIcon')->name('upload-loyalty-pic');
        Route::post('upload-apartment-pic', 'Apartment\ApartmentUserController@uploadApartmentIcon')->name('upload-apartment-pic');

        /// Notification
        Route::get('/notifications', 'HomeController@showNotification')->name('show.all.notification');
        Route::get('/read-all-notifications', 'HomeController@readNotification')->name('read.all.notification');
        Route::get('delete-notification/{id}', 'HomeController@deleteNotification')->name('delete.notification');
        Route::post('/markAsRead/notification', 'HomeController@markAsReadNotification')->name('markAsRead.notification');

        Route::get('/subscription', 'SubscriptionController@index')->name('subscription');
        Route::post('cancle-membership', 'StripeController@cancleMembership')->name('cancle-membership');
        Route::get('resume-membership', 'StripeController@resumeMembership')->name('resume-membership');

        Route::post('add-card', 'StripeController@addCard')->name('add-card');
        Route::post('delete-card', 'StripeController@deleteCard')->name('delete-card');
        Route::post('get-card', 'StripeController@getCard')->name('get-card');
        Route::post('update-card', 'StripeController@updateCard')->name('update-card');
        Route::post('set-default-card', 'StripeController@setDefaultCard')->name('set-default-card');

        Route::get('feed', 'FeedController@index')->name('feed');
        Route::post('getconcierges', 'FeedController@getConcierges')->name('getconcierges');
        // Route::get('chat', 'ChatController@index')->name('chat');
        // Route::get('feed', 'ChatController@feed')->name('feed');

        //Old Chat Route::get('chat/{id}', 'ChatController@chatParticular')->name('chatparticular');
        Route::get('chat', 'ChatController@chatListing')->name('chatparticular');
        Route::post('chatdetails', 'ChatController@chatSlide')->name('chatslide');
        Route::post('chatParticularslide', 'ChatController@chatParticularslide')->name('chatParticularslide');
        Route::post('chatsearch', 'ChatController@chatSearch')->name('chatsearch');
        Route::post('chatSidebarslide', 'ChatController@chatSidebarslide')->name('chatSidebarslide');

        Route::delete('myproductsDeleteAll', 'HomeController@deleteAll');

        Route::post('/add/user/status', 'FeedController@addUserStatus')->name('add.user.status');
        Route::post('/post/comment', 'FeedController@postComment')->name('post.comment');
        Route::post('/like/post', 'FeedController@likePost')->name('like.post');
        Route::post('/dis/like/post', 'FeedController@disLikePost')->name('dis.like.post');
        
        Route::post('/delete/post', 'FeedController@deletePost')->name('delete.post');
        Route::post('/get/post', 'FeedController@getPost')->name('get.post');
        Route::post('/update/post', 'FeedController@updatePost')->name('update.post');
        Route::post('/delete/post/comment', 'FeedController@deletePostComment')->name('delete.post.comment');
        Route::post('/delete/images', 'FeedController@deleteImages')->name('delete.images');
    }
);

/* for Amdin*/
include 'admin-routes.php';
