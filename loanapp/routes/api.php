	<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/* send otp */
Route::post('send_otp','Api\UserController@send_otp');
/* fill otp */
Route::post('fill_otp','Api\UserController@fill_otp');
/* sign up */
Route::post('create_pin','Api\UserController@create_pin');
/* login */
Route::post('login','Api\UserController@loginPin');
/* update profile */
Route::post('update_profile','Api\UserController@update_profile');
/* logout */
Route::post('logout','Api\UserController@logout');
/* forgotpin */
Route::post('forgotPin','Api\UserController@forgotPin');

/*******Used for Forgot OTP********/
Route::post('forgortNewPin','Api\UserController@forgortNewPin');
Route::post('forgotVerifyOTP','Api\UserController@forgotVerifyOTP');
Route::post('forgotCreateNewPin','Api\UserController@forgotCreateNewPin');

/* reset pin */
Route::get('resetpin','Api\UserController@resetpin');
/* income sources */
Route::get('income_sources','Api\UserController@incomeSources');
/* income sources */
Route::get('interest_rates','Api\LoanController@interestRates');
/* resetPasswordPost for apis users*/
Route::post('resetPasswordPost','Api\UserController@resetPasswordPost');
/* resetPasswordPost for apis users*/
Route::post('request_loan','Api\LoanController@requestLoan');
Route::post('post_loan','Api\LoanController@postLoan');
Route::post('loan_amount','Api\LoanController@loanAmount');
Route::post('give_loan_offer_information','Api\LoanController@giveLoanOfferInformation');
Route::post('give_loan_offer','Api\LoanController@giveLoanOffer');
Route::post('get_given_loan_offers','Api\LoanController@getGivenLoanOffers');
Route::post('get_received_loan_offers','Api\LoanController@getReceivedLoanOffers');
Route::post('accept_loan_offer','Api\LoanController@acceptLoanOffer');
Route::post('loan_detail','Api\LoanController@loan_detail');
Route::post('get_offers_givenby_entity','Api\LoanController@getOffersGivenByEntity');

Route::post('loan_request_list_accepted_by_user','Api\LoanController@loanReqListAccepByUser');
Route::post('loan_request_list_accepted_by_user','Api\LoanController@loanReqListAccepByUser');
Route::post('loan_request_rejected_by_user','Api\LoanController@loanReqRejectByUser');


Route::post('add_video','Api\LoanController@addVideo');

Route::post('loanApprovedList','Api\LoanController@loanApprovedList');

Route::post('duration_time','Api\LoanController@durationTime');

Route::get('loan_terms','Api\LoanController@loan_terms');

Route::get('loan_reasons','Api\LoanController@loan_reasons');

Route::post('amount_data','Api\LoanController@amount_data');

Route::post('loan_history','Api\LoanController@requestLoanHistory');

Route::post('fetch_device_info','Api\LoanController@fetchDeviceInfo');

Route::get('durations','Api\LoanController@durations');
Route::get('discounts','Api\LoanController@discounts');
Route::post('notifications','Api\LoanController@notifications');
Route::post('notifications_all_read','Api\LoanController@notifications_all_read');
Route::post('notifications_all_un_read_count','Api\LoanController@notifications_all_un_read_count');

Route::post('invite_friends','Api\LoanController@invite_friends');

Route::post('change_password','Api\UserController@change_password');

Route::post('change_notification_status','Api\LoanController@changeNotificationStatus');	

Route::get ( 'terms-of-service',
function () {
    return view ( 'api/terms-of-service' );
} );
Route::get ( 'privacy-policy',
    function () {
        return view ( 'api/privacy-policy' );
} );
Route::get ( 'contact-us',
function () {
   return view ( 'api/contact-us' );
} );
Route::get ( 'about-us',
  function () {
    return view ( 'api/about-us' );
} );

Route::post('current_loan_status','Api\LoanController@currentLoanStatus');
Route::post('history_status','Api\LoanController@history_status');
Route::post('fetch_credit_limit_score','Api\LoanController@fetch_credit_limit_score');

Route::post('loanCompletedStatus','Api\LoanController@loanCompletedStatus');

