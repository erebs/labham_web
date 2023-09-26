 <?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserApiController;



Route::post('/check-number', [UserApiController::class, 'check_number']);
Route::post('/register', [UserApiController::class, 'register']);
Route::post('/login', [UserApiController::class, 'login']);
Route::post('/send-otp', [UserApiController::class, 'send_otp']);
Route::post('/reset-password', [UserApiController::class, 'reset_password']);


Route::middleware(['auth:sanctum'])->group(function () {

Route::get('/home', [UserApiController::class, 'home']);
Route::get('/all-categories', [UserApiController::class, 'all_categories']);
Route::get('/all-products', [UserApiController::class, 'all_products']);

Route::get('/popular-products', [UserApiController::class, 'popular_products']);
Route::get('/featured-products', [UserApiController::class, 'featured_products']);
Route::get('/trending-products', [UserApiController::class, 'trending_products']);
Route::get('/categorywise-products/{catid}', [UserApiController::class, 'categorywise_products']);
Route::get('/product-details/{pid}', [UserApiController::class, 'product_details']);

Route::get('/user-profile', [UserApiController::class, 'user_profile']);
Route::post('/edit-profile', [UserApiController::class, 'edit_profile']);

Route::get('/all-address', [UserApiController::class, 'all_address']);
Route::post('/add-address', [UserApiController::class, 'add_address']);
Route::post('/edit-address', [UserApiController::class, 'edit_address']);
Route::post('/default-address', [UserApiController::class, 'default_address']);
Route::post('/delete-address', [UserApiController::class, 'delete_address']);

Route::get('/cart', [UserApiController::class, 'cart']);
Route::get('/cart-count', [UserApiController::class, 'cart_count']);

Route::post('/add-item', [UserApiController::class, 'add_item']);
Route::post('/delete-item', [UserApiController::class, 'delete_item']);
Route::post('/increase-qty', [UserApiController::class, 'increase_qty']);
Route::post('/decrease-qty', [UserApiController::class, 'decrease_qty']);

Route::get('/bank-details', [UserApiController::class, 'bank_details']);
Route::post('/place-order', [UserApiController::class, 'place_order']);

Route::get('/orders', [UserApiController::class, 'orders']);
Route::post('/cancel-order', [UserApiController::class, 'cancel_order']);

Route::post('/search-product', [UserApiController::class, 'search_product']);


});
























/***************************************************************************************************/
/******************************************** COMMON SIDE ******************************************/
/***************************************************************************************************/


// Route::get('/getpincodedetails', 'ApiController@getPincodeDetails');
// Route::get('/pincode/search', 'ApiController@searchPincode');
// Route::get('/pincode/search/addpincode', 'ApiController@addWebPincode');
// Route::get('/search', 'ApiController@search');

// Route::get('/search/subcategory', 'ApiController@searchSubCategory');

// Route::post('/address/default', 'ApiController@defaultAddress');


/************************************************************************************************************/
/************************************************ CUSTOMERS *************************************************/
/************************************************************************************************************/
// Route::post('/search/pincodes', 'ApiController@searchPincodes');
// Route::post('/search/home', 'ApiController@searchHome');
// Route::post('/home', 'ApiController@home');


// Route::post('/customer/login', 'ApiController@login');
// Route::post('/check/customer/number', 'ApiController@checkCustomerNumber');
// Route::post('/check/customer/email', 'ApiController@checkCustomerEmail');
// Route::post('/customer/sendregotp', 'ApiController@sentRegOTP');
// Route::post('/customer/verifyotp', 'ApiController@verifyOTP');
// Route::post('/customer/register', 'ApiController@register');
// Route::post('/customer/update/{id}', 'ApiController@update');
// Route::post('/customer/register/sendotp', 'ApiController@registerSendOTP');

// Route::post('/products', 'ApiController@products');
// Route::post('/product/{id}', 'ApiController@product');

// Route::post('/addtocart',     'ApiController@addToCart');
// Route::post('/removecart',     'ApiController@removeCart');
// Route::post('/changequantity',     'ApiController@changeQuantity');
// Route::post('/cartcount',     'ApiController@getCartCount');
// Route::post('/getcartsumtotal',     'ApiController@getCartSumTotal');
// Route::post('/getcart',     'ApiController@getCart');
// Route::post('/clearcart',     'ApiController@clearCart');
// Route::post('/placeorder',     'ApiController@placeOrder');



// Route::post('/orders',     'ApiController@orders');
// Route::post('/order/{id}',     'ApiController@order');
// Route::post('/order/status/{id}',     'ApiController@changeOrderStatus');
// Route::post('/payment/status/{id}',     'ApiController@changePaymentStatus');

// Route::post('/notifications',     'ApiController@notifications');

// Route::get('/address', 'ApiController@address');
// Route::get('/address/create', 'ApiController@storeAddress');
// Route::get('/address/{id}', 'ApiController@showAddress')->where('id', '[0-9]+');
// Route::post('/address/update/{id}', 'ApiController@updateAddress')->where('id', '[0-9]+');
// Route::get('/address/remove/{id}', 'ApiController@removeAddress')->where('id', '[0-9]+');
