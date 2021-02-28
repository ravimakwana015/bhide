<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login','API\UserController@login');
Route::post('updatelogin','API\UserController@updatelogin');
// Route::post('register','API\UserController@register');
Route::post('sendVerificationCode','API\UserController@sendVerificationCode');
Route::post('changePassword','API\UserController@changePassword');
Route::post('get-user-details','API\UserController@getUserDetails');
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('home','API\UserController@home');
    Route::post('update-user','API\UserController@updateUserDetails');
    Route::post('saveDeviceToken','API\UserController@saveDeviceToken');
    Route::post('concierge-details','API\ConciergesController@conciergeDetails');
    Route::post('emergencyContact','API\UserController@emergencyContact');
    Route::post('services','API\ServicesController@services');
    Route::post('adverts','API\AdvertsController@adverts');
    Route::post('emergencyMessages','API\EmergencyAlarmController@emergencyMessages');
    Route::post('messages','API\MessageBoardController@messages');
    Route::post('facilities','API\FacilitiesController@facilities');
    Route::post('parcels','API\ParcelsController@parcels');
    Route::post('loyalty-card-stores','API\LoyaltyCardController@loyaltyCardStores');
    Route::post('safeUnsafeStatusUpdate','API\EmergencyAlarmController@safeUnsafeStatusUpdate');
    Route::post('polls','API\PollsController@polls');
    Route::post('isPollConduct','API\PollsController@isPollConduct');
    Route::post('selectPollOption','API\PollsController@selectPollOption');
    Route::post('get-poll-result','API\PollsController@getPollResult');
    Route::post('visitors','API\VisitorsController@visitors');
    Route::post('unit-issues', 'API\UnitIssueRequestController@index');
    Route::post('add-issue', 'API\UnitIssueRequestController@store');
    Route::post('get-issue', 'API\UnitIssueRequestController@edit');
    Route::post('update-issue', 'API\UnitIssueRequestController@update');
    Route::post('destroy-issue', 'API\UnitIssueRequestController@destroy');

    Route::post('add-realEstate', 'API\RealEstateController@store');
    Route::post('detail-realEstate', 'API\RealEstateController@detailRealEstate');
    Route::post('edit-realEstate', 'API\RealEstateController@edit');
    Route::post('update-realEstate', 'API\RealEstateController@update');
    Route::post('user-properties', 'API\RealEstateController@ownrealState');
    Route::post('delete-realEstate', 'API\RealEstateController@deleterealEstate');
    Route::post('filters', 'API\RealEstateController@searchFilters');
    Route::post('add-feed', 'API\FeedController@addUserStatus');
    Route::post('get-feed', 'API\FeedController@getPost');
    Route::post('update-feed', 'API\FeedController@updatePost');
    Route::post('update-feeds', 'API\FeedController@updatePosts');
    Route::post('delete-feed', 'API\FeedController@deletePost');
    Route::post('likePost', 'API\FeedController@likePost');
    Route::post('disLikePost', 'API\FeedController@disLikePost');
    Route::post('postComment', 'API\FeedController@postComment');
    Route::post('getComment', 'API\FeedController@getComment');

    Route::post('get-feeds', 'API\FeedsController@index');
    Route::post('add-feeds', 'API\FeedsController@store');
    Route::post('all-notification','API\UserController@showNotification');
    Route::post('delete-notification','API\UserController@deleteNotification');
    Route::post('about-apartments','API\AboutApartmentController@getapartments');
    Route::post('about-apartments-update','API\AboutApartmentController@aboutApartmentUpdate');
    Route::post('bill-apartments-update','API\AboutApartmentController@billApartmentUpdate');
    Route::post('getAgent','API\UserController@getAgent');

    Route::post('get-notes','API\NoteController@index');
    Route::post('add-notes','API\NoteController@store');
    Route::post('update-notes','API\NoteController@updateNote');
    Route::post('delete-notes','API\NoteController@deleteNote');
        // Route::post('add-feeds', 'API\FeedsController@store');

    Route::post('get-chat','API\ChatController@chatDetails');
    Route::post('send-message','API\ChatController@store');

    Route::post('listing-chat','API\ChatController@chatList');
    Route::post('chatlisting-search','API\ChatController@chatSearch');

    Route::post('add-bill','API\AboutApartmentController@addBill');
    Route::post('email-realEstate','API\AboutApartmentController@addEmail');
    Route::post('git-bill','API\AboutApartmentController@getBill');
    Route::post('git-records','API\AboutApartmentController@getRecords');

});
Route::post('get-realEstate', 'API\RealEstateController@index');
Route::post('rent-realEstate', 'API\RealEstateController@rentEstate');
