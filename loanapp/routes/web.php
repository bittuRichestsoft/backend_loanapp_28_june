<?php

Route::redirect('/', '/login');

Route::redirect('/home', '/admin');

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');

    Route::resource('permissions', 'PermissionsController');

    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');

    Route::resource('roles', 'RolesController');

    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');

    Route::resource('users', 'UsersController');

    Route::delete('products/destroy', 'ProductsController@massDestroy')->name('products.massDestroy');

    Route::resource('products', 'ProductsController');

    Route::delete('income_sources/destroy', 'IncomeSourcesController@massDestroy')->name('income_sources.massDestroy');

    Route::resource('income_sources', 'IncomeSourcesController');

    Route::delete('interest_rates/destroy', 'InterestRatesController@massDestroy')->name('interest_rates.massDestroy');

    Route::resource('interest_rates', 'InterestRatesController');

    Route::delete('loan_amount/destroy', 'LoanAmountController@massDestroy')->name('loan_amount.massDestroy');

    Route::resource('loan_amount', 'LoanAmountController');

    Route::delete('loan_duration/destroy', 'LoanDurationController@massDestroy')->name('loan_duration.massDestroy');

    Route::resource('loan_duration', 'LoanDurationController');

    Route::delete('loan_reason/destroy', 'LoanReasonsController@massDestroy')->name('loan_reason.massDestroy');

    Route::resource('loan_reason', 'LoanReasonsController');

    Route::delete('loan_requests/destroy', 'LoanRequestsController@massDestroy')->name('loan_requests.massDestroy');

    Route::resource('loan_requests', 'LoanRequestsController');

    Route::delete('emi_history/destroy', 'EmiHistoryController@massDestroy')->name('emi_history.massDestroy');

    Route::resource('emi_history', 'EmiHistoryController');

    Route::delete('loan_offers/destroy', 'LoanOffersController@massDestroy')->name('loan_offers.massDestroy');

    Route::resource('loan_offers', 'LoanOffersController');

    Route::delete('clients/destroy', 'ClientsController@massDestroy')->name('clients.massDestroy');

    Route::resource('clients', 'ClientsController');

    Route::delete('projects/destroy', 'ProjectsController@massDestroy')->name('projects.massDestroy');

    Route::resource('projects', 'ProjectsController');
});
