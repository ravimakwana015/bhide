<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Admin'], function () {
    /*For Login*/
    Route::get('/adminstration/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/adminstration/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/adminstration/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::group(['middleware' => 'auth:admin', 'prefix' => 'adminstration/'], function () {
        Route::get('/', 'AdminController@index')->name('admin.home');
        Route::resources([
            'companies'       => 'Company\CompanyController',
            'transaction'     => 'Transaction\TransactionController',
            'service'         => 'Service\ServiceController',
            'servicecategory' => 'ServiceCategory\ServiceCategoryController',
            'facilitie'       => 'Facilitie\FacilitieController',
            'agent'           => 'Agent\AgentController',
            'loyaltycards'    => 'LoyaltyCards\LoyaltyCardsController',
            'loyaltystores'   => 'LoyaltyStores\LoyaltyStoresController',
            'loyaltystorescategory'   => 'LoyaltyStoresCategory\LoyaltyStoresCategoryController',
            'parcel'          => 'Parcel\ParcelController',
            'issue'           => 'Issue\IssueController',
            'poll'            => 'Poll\PollController',
            'emergencys'      => 'Emergency\EmergencysController',
            'members'      => 'Member\MembersController',
            'concierge' => 'Concierge\ConciergeController',
            'features' => 'Features\FeaturesController',
            'seo' => 'SEO\SeoController',
            'alluser' => 'Alluser\AllUserController',
            'advert' => 'Adverts\AdvertsController',
						'facilitiesoptions' => 'FacilitiesOptions\FacilitiesOptionController',
						'realEstate'      => 'RealEstate\RealEstateController',
        ]);
        Route::post('get-advert', 'Adverts\AdvertsController@getAdvert')->name('get.advert');

        Route::get('send-login-details/{company_id}', 'Company\CompanyController@sendLoginDetails') -> name('send.login.details');
        Route::get('send-payment-link/{company_id}', 'Company\CompanyController@sendPaymentLink') -> name('send.payment.link');
        Route::get('invoice/{company_id}/{invoice_id}', 'Company\CompanyController@downloadInvoice') -> name('download.invoice');

        Route::get('/data', 'AdminController@chart')->name('admin.chart');

        Route::get('details', 'AdminController@adminDetails')->name('admin.details');
        Route::post('updatedetails', 'AdminController@adminUpdateDetails')->name('admin.update');
        Route::post('changepassword', 'AdminController@adminUserChangePassword')->name('admin.changepassword');

        Route::post('get-company', 'Company\CompanyDataTablesController@getData') -> name('get.company');
        Route::post('get-concierge', 'Concierge\ConciergeDataTablesController@getData')->name('get.concierge');

        Route::post('get-transaction', 'Transaction\TransactionDataTablesController@getData') -> name('get.transaction');

        Route::post('get-service', 'Service\ServiceDataTablesController@getData')->name('get.service');
        Route::get('/service/edit/{id}', 'Service\ServiceController@editservice')->name('admin.service.edit');
        Route::post('/service/update', 'Service\ServiceController@updateservice')->name('admin.service.update');
        Route::post('/service/delete', 'Service\ServiceController@deleteservice')->name('admin.service.delete');

        Route::post('get-servicecategory', 'ServiceCategory\ServiceCategoryDataTablesController@getData')->name('get.servicecategory');
        Route::get('/servicecategory/edit/{id}', 'ServiceCategory\ServiceCategoryController@editservice')->name('admin.servicecategory.edit');
        Route::post('/servicecategory/update', 'ServiceCategory\ServiceCategoryController@updateservice')->name('admin.servicecategory.update');
        Route::post('/servicecategory/delete', 'ServiceCategory\ServiceCategoryController@deleteservice')->name('admin.servicecategory.delete');

        Route::post('get-loyaltystorescategory', 'LoyaltyStoresCategory\LoyaltyStoresCategoryDataTablesController@getData')->name('get.loyaltystorescategory');
        Route::get('/loyaltystorescategory/edit/{id}', 'LoyaltyStoresCategory\LoyaltyStoresCategoryController@editLoyaltyStores')->name('admin.loyaltystorescategory.edit');
        Route::post('/loyaltystorescategory/update', 'LoyaltyStoresCategory\LoyaltyStoresCategoryController@updateLoyaltyStores')->name('admin.loyaltystorescategory.update');
        Route::post('/loyaltystorescategory/delete', 'LoyaltyStoresCategory\LoyaltyStoresCategoryController@deleteLoyaltyStores')->name('admin.loyaltystorescategory.delete');

        Route::post('get-facilitie', 'Facilitie\FacilitieDataTablesController@getData')->name('get.facilitie');
        Route::get('/facilitie/edit/{id}', 'Facilitie\FacilitieController@editfacilitie')->name('admin.facilitie.edit');
        Route::post('/facilitie/update', 'Facilitie\FacilitieController@updatefacilitie')->name('admin.facilitie.update');
        Route::post('/facilitie/delete', 'Facilitie\FacilitieController@deletefacilitie')->name('admin.facilitie.delete');

        Route::post('get-loyaltystore', 'LoyaltyStores\LoyaltyStoresDataTablesController@getData')->name('get.loyaltystores');
        Route::get('/loyaltystores/edit/{id}', 'LoyaltyStores\LoyaltyStoresController@editLoyaltyStores')->name('admin.loyaltystores.edit');
        Route::post('/loyaltystores/update', 'LoyaltyStores\LoyaltyStoresController@updateLoyaltyStores')->name('admin.loyaltystores.update');
        Route::post('/loyaltystores/delete', 'LoyaltyStores\LoyaltyStoresController@deleteLoyaltyStores')->name('admin.loyaltystores.delete');

        Route::post('get-units', 'Parcel\ParcelController@getUnits')->name('get.units');
        Route::post('get-parcel', 'Parcel\ParcelDataTablesController@getData')->name('get.parcel');
        Route::get('/parcel/edit/{id}', 'Parcel\ParcelController@editparcel')->name('admin.parcel.edit');
        Route::post('/adverts/editAdvert', 'Adverts\AdvertsController@editAdverts')->name('admin.advert.edit');
        Route::post('/adverts/update', 'Adverts\AdvertsController@update')->name('admin.advert.update');
        Route::post('/adverts/delete', 'Adverts\AdvertsController@delete')->name('admin.advert.delete');
        Route::post('/parcel/update', 'Parcel\ParcelController@updateparcel')->name('admin.parcel.update');
        Route::post('/parcel/delete', 'Parcel\ParcelController@deleteparcel')->name('admin.parcle.delete');

        Route::post('get-poll', 'Poll\PollController@getPolls')->name('get.poll');
        Route::post('get-poll-adminresult', 'Poll\PollController@getPollResult')->name('get.poll.adminresult');

        Route::post('get-issue', 'Issue\IssueDataTablesController@getData')->name('get.issue');
        Route::post('emergency-response', 'Emergency\EmergencysDataTablesController@getData')->name('admin.emergency.response');
        Route::post('get-alluser', 'Alluser\AllUserDataTablesController@getData')->name('allusers.get');

        Route::get('get-gate', 'Concierge\ConciergeController@getGates')->name('get.gate');
        Route::post('add-gates', 'Concierge\ConciergeController@addGate')->name('add.gates');
        Route::post('upload-concierges-pic-admin', 'Concierge\ConciergeController@uploadConciergesIcon')->name('upload-concierges-pic-admin');

        Route::resource('pages', 'Pages\PagesController');
        Route::post('pages/get', 'Pages\PagesTableController')->name('pages.get');
        Route::get('/pages/edit/{id}', 'Pages\PagesController@editpages')->name('admin.pages.edit');
        Route::post('/pages/update', 'Pages\PagesController@updatepages')->name('admin.pages.update');
        Route::post('/pages/delete', 'Pages\PagesController@deletepages')->name('admin.pages.delete');

        Route::get('/alluser/edit/{id}', 'Alluser\AllUserController@editallusers')->name('admin.alluser.edit');
        Route::post('/alluser/update', 'Alluser\AllUserController@updateusers')->name('admin.alluser.update');
        Route::post('/alluser/delete', 'Alluser\AllUserController@deleteusers')->name('admin.alluser.delete');
        Route::post('upload-alluser-pic', 'Alluser\AllUserController@uploadAllIcon')->name('upload-alluser-pic');
        Route::get('send-login-details-admin/{user_id}', 'Alluser\AllUserController@sendLoginDetails')->name('send_login_details_admin');

        Route::post('features/get', 'Features\FeaturesDatatablesController')->name('features.get');
        Route::get('/features/edit/{id}', 'Features\FeaturesController@editfeatures')->name('admin.features.edit');
        Route::post('/features/update', 'Features\FeaturesController@updatefeatures')->name('admin.features.update');
        Route::post('/features/store', 'Features\FeaturesController@storefeatures')->name('admin.features.store');
        Route::post('/features/delete', 'Features\FeaturesController@deletefeatures')->name('admin.features.delete');

        Route::post('facilitiesoptions/get', 'FacilitiesOptions\FacilitiesOptionDataTablesController')->name('facilitiesoptions.get');
        Route::get('/facilitiesoptions/edit/{id}', 'FacilitiesOptions\FacilitiesOptionController@editfacilitiesoptions')->name('admin.facilitiesoptions.edit');
        Route::post('/facilitiesoptions/update', 'FacilitiesOptions\FacilitiesOptionController@updatefacilitiesoptions')->name('admin.facilitiesoptions.update');
        Route::post('/facilitiesoptions/delete', 'FacilitiesOptions\FacilitiesOptionController@deletefacilitiesoptions')->name('admin.facilitiesoptions.delete');


        /// Reports

        Route::get('/reports/user-reports', 'Report\ReportController@userReports')->name('user.reports');
        Route::post('/reports/get-reports', 'Report\ReportController@getData')->name('get.user');

        Route::get('/reports/company-reports', 'Report\ReportController@companyReports')->name('reportcompany.reports');
        Route::post('/reporst/get-company-reports', 'Report\ReportController@getCompanyData')->name('get.reportcompany');

        Route::get('/reports/transaction-reports', 'Report\ReportController@transactionReports')->name('reporttransactions.reports');
        Route::post('/reporst/get-transaction-reports', 'Report\ReportController@gettransactionData')->name('get.reporttransactions');

        Route::post('admin-upload-profile-pic', 'Company\CompanyController@uploadBuildingIcon')->name('admin-upload-profile-pic');

        Route::post('/seo/update', 'SEO\SeoController@updateseo')->name('admin.seo.update');
        Route::get('settings/{id}', 'Settings\SettingsController@edit') -> name('settings.edit');
        Route::post('update-settings', 'Settings\SettingsController@settingsUpdate') -> name('settings.update');
    });
});
