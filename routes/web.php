<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CookieController;


/*****************************************************************************************************/
/********************************************** ADMIN SIDE *******************************************/
/*****************************************************************************************************/

/*********************************** Admin index & login sessions ************************************/

Route::post('/import_excel/import', 'AdminProductsController@import');
Route::post('/export_excel/export', 'AdminProductsController@export');
Route::get('/admin', 'AdminController@index');
Route::get('/admin/login', 'AdminController@login');
Route::Post('/admin/login', 'AdminController@check');
Route::get('/admin/logout', 'AdminController@logout');
Route::get('/admin/login/user/{id}', 'AdminController@adminLogin');
Route::get('/admin/login/user/{id}/{type}', 'AdminController@superAdminLogin');
Route::get('/admin/analytics', 'AdminController@analytics');

/**************************************** Admin banners sessions ***************************************/
Route::get('/admin/banners', 'AdminBannerController@listFirst');
Route::get('/admin/banners/first', 'AdminBannerController@listFirst');
Route::get('/admin/banners/second', 'AdminBannerController@listSecond');
Route::get('/admin/banners/third', 'AdminBannerController@listThird');
Route::get('/admin/banners/fourth', 'AdminBannerController@listFourth');
Route::post('/admin/banners/create', 'AdminBannerController@create');
Route::post('/admin/banners/update', 'AdminBannerController@update');
Route::post('/admin/banners/delete/{type}/{id}', 'AdminBannerController@destroy');

/************************************** Admin Category Controls **************************************/
Route::get('/admin/category', 'AdminCategoryController@index');
Route::post('/admin/category/create', 'AdminCategoryController@create');
Route::post('/admin/category/update', 'AdminCategoryController@update');
Route::post('/admin/category/delete/{id}', 'AdminCategoryController@destroy');

/************************************ Admin Sub-Category Controls ************************************/
Route::get('/admin/subcategory', 'AdminCategoryController@subcategory');
Route::post('/admin/subcategory/create', 'AdminCategoryController@createSubCategory');
Route::post('/admin/subcategory/update', 'AdminCategoryController@updateSubCategory');
Route::post('/admin/subcategory/delete/{id}', 'AdminCategoryController@destroySubCategory');

/************************************** Admin Category Controls **************************************/
Route::get('/admin/brands', 'AdminBrandsController@index');
Route::post('/admin/brands/create', 'AdminBrandsController@create');
Route::post('/admin/brands/update', 'AdminBrandsController@update');
Route::post('/admin/brands/delete/{id}', 'AdminBrandsController@destroy');

/*************************************** Admin User Controls *****************************************/
Route::resource('/admin/products', 'AdminProductsController');
Route::post('/admin/products/delete/{id}', 'AdminProductsController@destroy');
Route::post('/admin/products/stock', 'AdminProductsController@stockUpdate');
Route::get('/admin/products/units/{id}', 'AdminProductsController@unitsList');
Route::post('/admin/products/units/save/{id}', 'AdminProductsController@unitSave');
Route::post('/admin/products/units/update/{id}', 'AdminProductsController@unitUpdate');
Route::post('/admin/products/units/delete/{id}', 'AdminProductsController@unitDelete');


Route::get('/admin/product-gallery/{id}', 'AdminProductsController@product_gallery');
Route::post('/admin/prod-gallery-create', 'AdminProductsController@prod_gallery_create');
Route::post('/admin/prod-gallery-delete/{id}/{pid}', 'AdminProductsController@prod_gallery_delete');

Route::get('/admin/product-videos/{id}', 'AdminProductsController@product_videos');
Route::post('/admin/prod-video-create', 'AdminProductsController@prod_video_create');
Route::post('/admin/prod-video-delete/{id}/{pid}', 'AdminProductsController@prod_video_delete');

/************************************* Admin Pincodes Controls ***************************************/
Route::get('/admin/pincodes', 'AdminController@pincodes');
Route::post('/admin/pincodes', 'AdminController@savePincodes');

/************************************* Admin Customer Controls ***************************************/
Route::get('/admin/customers', 'AdminCustomerController@index');

/************************************** Admin Orders Controls ****************************************/
Route::get('/admin/orders', 'AdminOrderController@index');
Route::get('/admin/orders/{id}', 'AdminOrderController@view');

/************************************* Admin Customer Controls ***************************************/
Route::get('/admin/notifications', 'AdminNotificationController@index');
Route::post('/admin/notifications/create', 'AdminNotificationController@create');
Route::post('/admin/notifications/delete/{id}', 'AdminNotificationController@destroy');


Route::get('/admin/settings', 'AdminController@settings');
Route::post('/admin/setsettings', 'AdminController@setsettings');







/*****************************************************************************************************/
/********************************************* AJAX SIDE *********************************************/
/*****************************************************************************************************/

Route::post('/ajax/search/products', 'AjaxController@searchProducts');
Route::get('/ajax/product/status',     'AjaxController@changeProductStatus');
Route::get('/ajax/productunit/status',     'AjaxController@changeProductUnitStatus');
Route::post('/ajax/getsizedetails',     'AjaxController@getSizeDetails');
Route::post('/ajax/addtocart',     'AjaxController@addToCart');
Route::post('/ajax/cartcount',     'AjaxController@getCartCount');
Route::get('/ajax/removecart',     'AjaxController@removeCart');
Route::get('/ajax/getcartcount',     'AjaxController@getCartCount');
Route::get('/ajax/changequantity',     'AjaxController@changeQuantity');


Route::get('/ajax/order/status',     'AjaxController@changeOrderStatus');
Route::get('/ajax/return/status',     'AjaxController@changeReturnStatus');
Route::get('/ajax/payment/status',     'AjaxController@changePaymentStatus');






/*****************************************************************************************************/
/********************************************* CLIENT SIDE *******************************************/
/*****************************************************************************************************/

/********************************** Client index & login sessions ************************************/


Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/about', [FrontendController::class, 'about']);
Route::get('/blog', [FrontendController::class, 'blog']);
Route::get('/contact', [FrontendController::class, 'contact']);
Route::get('/products', [FrontendController::class, 'products']);


Route::get('/v1/product/categories', [FrontendController::class, 'categories']);
Route::get('/v1/category-products/{cid}', [FrontendController::class, 'category_products']);
Route::get('/v1/productsingle/{cid}', [FrontendController::class, 'productsingle']);

Route::get('/popular-products', [FrontendController::class, 'popular_products']);
Route::get('/featured-products', [FrontendController::class, 'featured_products']);
Route::get('/trending-products', [FrontendController::class, 'trending_products']);

Route::get('/signup', [FrontendController::class, 'signup']);
Route::post('/signup', [FrontendController::class, 'user_signup']);

Route::get('/signin', [FrontendController::class, 'signin']);
Route::post('/signin', [FrontendController::class, 'user_signin']);

Route::post('/get-prod', [FrontendController::class, 'get_prod']);


Route::middleware(['MemLogChk','PreventBack'])->group(function () {
Route::get('/logout', [FrontendController::class, 'logout']);
Route::get('/profile', [FrontendController::class, 'profile']);
Route::post('/edit-profile', [FrontendController::class, 'edit_profile']);
Route::get('/addaddress', [FrontendController::class, 'addaddress']);
Route::post('/address-add', [FrontendController::class, 'address_add']);
Route::post('/def-address', [FrontendController::class, 'def_address']);
Route::get('/editaddress/{aid}', [FrontendController::class, 'editaddress']);
Route::post('/address-edit', [FrontendController::class, 'address_edit']);
Route::post('/delete-address', [FrontendController::class, 'delete_address']);
Route::get('/cart', [FrontendController::class, 'cart'])->name('member.cart');
Route::get('/checkout', [FrontendController::class, 'checkout']);
Route::post('/placeorder', [FrontendController::class, 'placeorder']);

Route::post('/delete-cart', [FrontendController::class, 'delete_cart']);
Route::post('/plus-cart', [FrontendController::class, 'plus_cart']);
Route::post('/minus-cart', [FrontendController::class, 'minus_cart']);
Route::post('/return-img', [FrontendController::class, 'return_img']);
Route::post('/del-image', [FrontendController::class, 'del_image']);
Route::post('/return-order', [FrontendController::class, 'return_order']);
Route::post('/cancel-order', [FrontendController::class, 'cancel_order']);
});
Route::post('/get-cartcount', [FrontendController::class, 'get_cartcount']);

Route::post('/add-to-cart', [FrontendController::class, 'add_to_cart']);
Route::post('/add-cart', [FrontendController::class, 'add_cart']);

Route::get('/v1/cart', [CookieController::class, 'cart'])->name('default.cart');
Route::post('/v1/delete-cart', [CookieController::class, 'delete_cart']);
Route::post('/v1/plus-cart', [CookieController::class, 'plus_cart']);
Route::post('/v1/minus-cart', [CookieController::class, 'minus_cart']);

Route::get('/terms', [FrontendController::class, 'terms']);
Route::get('/privacy-policy', [FrontendController::class, 'privacy_policy']);
Route::get('/faq', [FrontendController::class, 'faq']);
Route::get('/return-policy', [FrontendController::class, 'return_policy']);

Route::get('/forgot-password', [FrontendController::class, 'forgot_password']);
Route::post('/send-otp', [FrontendController::class, 'send_otp']);
Route::post('/password-reset', [FrontendController::class, 'password_reset']);

Route::get('/mycart', [FrontendController::class, 'mycart']);















// Route::get('/', 'HomeController@index');
// Route::get('/profile', 'HomeController@profile');
// Route::post('/profile', 'HomeController@saveProfile');

// Route::get('/logout', 'HomeController@logout');


// Route::get('/address', 'HomeController@address');
// Route::get('/address/create', 'HomeController@createAddress');
// Route::post('/address/store', 'HomeController@storeAddress');
// Route::get('/address/{id}', 'HomeController@showAddress')->where('id', '[0-9]+');
// Route::post('/address/update/{id}', 'HomeController@updateAddress')->where('id', '[0-9]+');
// Route::get('/address/remove/{id}', 'HomeController@removeAddress')->where('id', '[0-9]+');

// Route::get('/orders', 'HomeController@orders');
// Route::get('/order/{id}', 'HomeController@order');
// Route::get('/order/cancel/{id}', 'HomeController@cancelOrder');

// Route::get('/categories', 'HomeController@categories');

// Route::get('/products', 'HomeController@products');
// Route::get('/products/{cid}', 'HomeController@products');
// Route::get('/products/{cid}/{scid}', 'HomeController@products');

// Route::get('/product/{id}', 'HomeController@product');

// Route::get('/cart', 'HomeController@cart');
// Route::get('/checkout', 'HomeController@checkout');

// Route::get('/placeorder', 'HomeController@placeOrderCoD');
// Route::get('/placeorder/CoD', 'HomeController@placeOrderCoD');

// Route::get('/placeorder/Online', 'HomeController@placeOrderOnline');
// Route::post('/payresult', 'HomeController@payresult');
// Route::get('/payresult', 'HomeController@payresult');

// Route::get('/payment-success/{amt}', 'HomeController@paySuccess');

// Route::get('/notifications', 'HomeController@notifications');

// Route::get('/contactus', 'HomeController@contactus');
// Route::get('/aboutus', 'HomeController@aboutus');
// Route::get('/terms', 'HomeController@terms');
// Route::get('/privacy', 'HomeController@privacy');
// Route::get('/return', 'HomeController@return');

// Route::get('/refund', 'HomeController@refund');
// Route::get('/shipping', 'HomeController@shipping');

// Route::get('/mobile/contactus', 'HomeController@file1');
// Route::get('/mobile/aboutus', 'HomeController@file2');
// Route::get('/mobile/terms', 'HomeController@file3');
// Route::get('/mobile/privacy', 'HomeController@file4');
// Route::get('/mobile/return', 'HomeController@file5');
