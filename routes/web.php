<?php

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CampaignProductController;
use App\Http\Controllers\Admin\UserMessageController;
use App\Http\Controllers\Admin\SMSController;
use Illuminate\Support\Facades\Storage;
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

Route::get('/', function () {
    // return view('welcome');
    return response()->file('storage/back/back.jpg');
});


Route::any('send_sms1', [SMSController::class, 'sendSMS'])->name('send_sms1');

Route::any('/send_sms2', [SMSController::class, 'initiateSmsActivation'])->name('send_sms2');

Route::any('/send_sms3', [SMSController::class, 'doo'])->name('send_sms3');

Route::any('/send_sms4', [SMSController::class, 'doo_mtn'])->name('send_sms4');

Route::get('syriatel', [SMSController::class, 'syriatel']);



Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();


    Route::get('pointsForCampaign', [CampaignProductController::class, 'getPagePoints'])->name('points');
    Route::get('members-with-points/{id}', [CampaignProductController::class, 'getPageMemberPoints'])->name('members-with-points');

    Route::get('pointsForMember', [CampaignProductController::class, 'getPageMember'])->name('members');

    Route::get('claimsForCampaign', [CampaignProductController::class, 'getPageClaims'])->name('claims');

    Route::get('givenGifts', [CampaignProductController::class, 'givenGifts'])->name('givenGifts');

    Route::post('reset', [CampaignProductController::class, 'resetAll'])->name('reset');
    
    Route::post('delete-all-messages', [CampaignProductController::class, 'deleteMessages'])->name('delete-all-messages');

    Route::post('refuse/{id}', [CampaignProductController::class, 'refuse'])->name('refuse');

    Route::post('accept/{id}', [CampaignProductController::class, 'acceptPage'])->name('accept');
    
    Route::post('set-gift', [CampaignProductController::class, 'setGift'])->name('set-gift');

    Route::post('set-point', [CampaignProductController::class, 'setPoint'])->name('set-point');

    Route::get('ownAdminMessages', [CampaignProductController::class, 'ownAdminMessages'])->name('ownAdminMessages');
    // Route::get('ignoremessage/{id}', [UserMessageController::class, 'ignoremessage'])->name('ignoremessage');

    Route::post('delete-message/{id}', [CampaignProductController::class, 'deleteMessage'])->name('delete-message');

    Route::get('view-message/{id}', [CampaignProductController::class, 'viewMessage'])->name('view-message');

    //export points 
    Route::get('exportPdf/{id}', [CampaignProductController::class, 'exportPdf']);
    Route::get('export/{id}', [CampaignProductController::class, 'export']);
  
    //export gifts
    Route::get('exportExcelGifts/{id}', [CampaignProductController::class, 'exportExcelGifts']);
    Route::get('exportPdfGifts/{id}', [CampaignProductController::class, 'exportPdfGifts']);

    Route::get('campaigns-with-gifts', [CampaignProductController::class, 'get_all_campaigns'])->name('campaigns-with-gifts');
    Route::get('campaign-with-gifts/{id}', [CampaignProductController::class, 'get_all_gifts_campaign'])->name('campaign-with-gifts');



});

Route::get('add_product/{id}', [CampaignProductController::class, 'campaign_products'])->name('add_product');

// Route::post('add_product', [CampaignProductController::class, 'add_product'])->name('add_product');

//for campaigns page
Route::get('products/{id}', [CampaignProductController::class, 'getProducts'])->name('products');
Route::get('distributors/{id}', [CampaignProductController::class, 'getDistributors'])->name('distributors');
Route::get('gifts/{id}', [CampaignProductController::class, 'getGifts'])->name('gifts');


//campaign's points


//for user message page
Route::get('answermessage/{id}', [UserMessageController::class, 'answermessage'])->name('answermessage');
Route::get('ignoremessage/{id}', [UserMessageController::class, 'ignoremessage'])->name('ignoremessage');



