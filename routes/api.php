<?php

use App\Http\Middleware\CheckGuest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\GiftController;
use App\Http\Controllers\API\CityController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\DistributorController;
use App\Http\Controllers\API\ObserverController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\BillController;
use App\Http\Controllers\API\FavoriteController;
use App\Http\Controllers\API\CampaignController;
use App\Http\Controllers\API\PointController;
use App\Http\Controllers\API\UserMessageController;
use App\Http\Controllers\API\ClaimController;
use App\Http\Controllers\API\AdminMessageController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\Admin\SMSController;

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
//Auth

Route::post('test', [AuthController::class, 'redirectToSendMessageSyritel22']);
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

//check token
Route::post('check_token', [AuthController::class, 'checkToken']);

Route::post('codeVerify', [AuthController::class, 'codeVerify']);
Route::post('resendCode', [AuthController::class, 'resendcode']);

//Categories
Route::get('categories', [CategoryController::class, 'categories']);
Route::get('category/{id}', [CategoryController::class, 'categoryDetails']);

Route::get('category_tree/{id}', [CategoryController::class, 'categoryDetailAllTree']);
Route::get('category_details/{id}', [CategoryController::class, 'categoryDetailsForTree']);

//Cities
Route::get('cities', [CityController::class, 'cities']);

//work
Route::get('get_work', [CityController::class, 'get_work']);

//distributors 
Route::get('distributors', [DistributorController::class, 'distributors_by_id_cityId_isActive']);
Route::get('onlyDistributors', [UserMessageController::class, 'onlyDistributors']);

//observers ?
Route::get('observers', [ObserverController::class, 'observers_by_id_cityId_isActive']);

Route::group(['middleware' => ['IsMemberOrAdmin', 'auth:sanctum']], function () {
  //Gifts
  Route::get('/gifts_names', [GiftController::class, 'gifts_names']);

});

Route::group(['middleware' => ['distributorOrmember', 'auth:sanctum']], function () {
  //profile
  Route::put('profile', [ProfileController::class, 'profile']);
  Route::post('changePassword', [ProfileController::class, 'changePassword']);
});

Route::group(['middleware' => ['member', 'auth:sanctum']], function () {

  Route::post('uploadBill', [BillController::class, 'upload_bill']);
  Route::post('delete_bill', [BillController::class, 'delete_bill']);

  //favorites
  Route::post('favorite', [FavoriteController::class, 'favorite']);
  Route::get('favorites', [FavoriteController::class, 'getFavorites']);

   //notifications
   Route::get('notifications', [NotificationController::class, 'notifications']);

});

Route::group(['middleware' => ['distributorOrmember', 'auth:sanctum']], function () {

  Route::get('current_campaign', [CampaignController::class, 'current_campaign']);

});

Route::group(['middleware' => ['jointmember', 'auth:sanctum']], function () {
  //my points
  Route::get('points', [PointController::class, 'points']);

  //my gifts
  Route::get('mygifts', [GiftController::class, 'mygifts']);

  //claim
  Route::post('claim', [ClaimController::class, 'claim']);


});

Route::group(['middleware' => ['member', 'auth:sanctum']], function () {
  //Bills
  Route::get('bills_app1', [BillController::class, 'bills_app1']);
});


Route::group(['middleware' => ['observer', 'auth:sanctum']], function () {
  //Bills
  Route::get('bills_app2', [BillController::class, 'bills_app2']);

   //claims
   Route::get('claims', [ClaimController::class, 'claims']);

   //given gifts
   Route::get('given_gifts', [GiftController::class, 'given_gifts']);
   Route::get('given_gifts_by_id/{id}', [GiftController::class, 'given_gifts_by_id']);

   
});

Route::group(['middleware' => ['distributor', 'auth:sanctum']], function () {
  //Bills
  Route::get('bills_app1_sales', [BillController::class, 'bills_app1_sales']);

  //messages
  Route::get('get_memebers_messages', [UserMessageController::class, 'get_memebers_messages']);
  

});


Route::group(['middleware' => ['distributorOrmember', 'auth:sanctum']], function () {
  //user message by member or distributor
  Route::post('sendmessageByMember', [UserMessageController::class, 'send_message_member_or_distributor']);

});

 //user message by guest
 Route::post('sendMessageByGuest', [UserMessageController::class, 'send_message_by_guest']);

   //Products
   Route::get('product/{id}', [ProductController::class, 'productDetails']);
   Route::get('products', [ProductController::class, 'products']);

   Route::post('orderProducts', [ProductController::class, 'orderProducts']);

   




Route::group(['middleware' => ['auth:sanctum']], function () {
  
  //logout
  Route::post('logout', [AuthController::class, 'logout']);

  //admin messages
  Route::get('messages', [AdminMessageController::class, 'messages']);

  Route::post('deviceToken', [NotificationController::class, 'saveDeviceToken']);

});
