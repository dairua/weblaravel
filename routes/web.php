<?php

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
//Frontend 
Route::get('/','HomeController@index' );
Route::get('/trang-chu','HomeController@index');
Route::get('/404','HomeController@error_page');
Route::post('/tim-kiem','HomeController@search');
Route::post('/autocomplete-ajax','HomeController@autocomplete_ajax');

//LienHe
Route::get('/lien-he','ContactController@lien_he' );
Route::get('/information','ContactController@information' );
Route::post('/save-infor','ContactController@save_infor' );
Route::post('/update-infor/{info_id}','ContactController@update_infor' );

//Danh muc san pham trang chu
Route::get('/danh-muc/{slug_category_product}','CategoryProduct@show_category_home');
Route::get('/thuong-hieu/{brand_slug}','BrandProduct@show_brand_home');
Route::get('/chi-tiet/{product_slug}','ProductController@details_product');

//BaiViet
Route::get('/danh-muc-bai-viet/{post_slug}','PostController@danh_muc_bai_viet');
Route::get('/bai-viet/{post_slug}','PostController@bai_viet');

//Backend
Route::get('/admin','AdminController@index');
Route::get('/dashboard','AdminController@show_dashboard');
Route::get('/order-date','AdminController@order_date');
Route::post('/filter-by-date','AdminController@filter_by_date');
Route::post('/days-order','AdminController@days_order');
Route::get('/logout','AdminController@logout');
Route::post('/admin-dashboard','AdminController@dashboard');
Route::post('/dashboard-filter','AdminController@dashboard_filter');


//Category Product
Route::get('/add-category-product','CategoryProduct@add_category_product');
Route::get('/edit-category-product/{category_product_id}','CategoryProduct@edit_category_product');
Route::get('/delete-category-product/{category_product_id}','CategoryProduct@delete_category_product');
Route::get('/all-category-product','CategoryProduct@all_category_product');

Route::post('/export-csv','CategoryProduct@export_csv');
Route::post('/import-csv','CategoryProduct@import_csv');

Route::get('/unactive-category-product/{category_product_id}','CategoryProduct@unactive_category_product');
Route::get('/active-category-product/{category_product_id}','CategoryProduct@active_category_product');

Route::post('/save-category-product','CategoryProduct@save_category_product');
Route::post('/update-category-product/{category_product_id}','CategoryProduct@update_category_product');
//Send Mail 
Route::get('/send-mail','HomeController@send_mail');
Route::get('/quen-mat-khau','HomeController@quen_mat_khau');

// //Login facebook
// Route::get('/login-facebook','AdminController@login_facebook');
// Route::get('/admin/callback','AdminController@callback_facebook');

//Login google
Route::get('/login-google','AdminController@login_google');
Route::get('/google/callback','AdminController@callback_google');

//Login customer google
Route::get('/login-customer-google','AdminController@login_customer_google');
Route::get('/customer/google/callback','AdminController@callback_customer_google');


//Brand Product
Route::get('/add-brand-product','BrandProduct@add_brand_product');
Route::get('/edit-brand-product/{brand_product_id}','BrandProduct@edit_brand_product');
Route::get('/delete-brand-product/{brand_product_id}','BrandProduct@delete_brand_product');
Route::get('/all-brand-product','BrandProduct@all_brand_product');

Route::get('/unactive-brand-product/{brand_product_id}','BrandProduct@unactive_brand_product');
Route::get('/active-brand-product/{brand_product_id}','BrandProduct@active_brand_product');

Route::post('/save-brand-product','BrandProduct@save_brand_product');
Route::post('/update-brand-product/{brand_product_id}','BrandProduct@update_brand_product');

//Category post
Route::get('/add-category-post','CategoryPost@add_category_post');
Route::get('/edit-category-post/{category_post_id}','CategoryPost@edit_category_post');
Route::post('/save-category-post','CategoryPost@save_category_post');
Route::get('/all-category-post','CategoryPost@all_category_post');
Route::post('/update-category-post/{cate_id}','CategoryPost@update_category_post');
Route::get('/danh-muc-bai-viet/{cate_post_slug}','CategoryPost@danh_muc_bai_viet');
Route::get('/delete-category-post/{cate_id}','CategoryPost@delete_category_post');

Route::get('/unactive-category-post/{cate_post_id}','CategoryPost@unactive_category_post');
Route::get('/active-category-post/{cate_post_id}','CategoryPost@active_category_post');

//Post
Route::get('/add-post','PostController@add_post');
Route::get('/all-post','PostController@all_post');
Route::get('/delete-post/{post_id}','PostController@delete_post');
Route::get('/edit-post/{post_id}','PostController@edit_post');
Route::post('/save-post','PostController@save_post');
Route::post('/update-post/{post_id}','PostController@update_post');


Route::group(['middleware' => 'auth.roles'], function () {
	Route::get('/add-product','ProductController@add_product');
    Route::get('/edit-product/{product_id}','ProductController@edit_product');
});
// Route::get('users',
// 		[
// 			'users'=>'UserController@index',
// 			'as'=> 'Users',
// 			'middleware'=> 'auth.roles',
// 			// 'auth.roles' => ['admin','author'],
// 		]);
Route::get('users','UserController@index')->middleware('auth.roles');
Route::get('impersonate/{admin_id}','UserController@impersonate');
Route::get('impersonate-destroy','UserController@impersonate_destroy');
Route::get('delete-user-roles/{admin_id}','UserController@delete_user_roles')->middleware('auth.roles');
Route::get('add-users','UserController@add_users')->middleware('auth.roles');
Route::post('store-users','UserController@store_users');
Route::post('assign-roles','UserController@assign_roles')->middleware('auth.roles');

//Product
Route::get('/add-product','ProductController@add_product');
Route::get('/edit-product/{product_id}','ProductController@edit_product');
Route::get('/delete-product/{product_id}','ProductController@delete_product');
Route::get('/all-product','ProductController@all_product');
Route::get('/unactive-product/{product_id}','ProductController@unactive_product');
Route::get('/active-product/{product_id}','ProductController@active_product');
Route::post('/save-product','ProductController@save_product')->name('save.product');
Route::post('/update-product/{product_id}','ProductController@update_product');

//Coupon
Route::post('/check-coupon','CartController@check_coupon');

Route::get('/unset-coupon','CouponController@unset_coupon');
Route::get('/insert-coupon','CouponController@insert_coupon');
Route::get('/delete-coupon/{coupon_id}','CouponController@delete_coupon');
Route::get('/list-coupon','CouponController@list_coupon');
Route::post('/insert-coupon-code','CouponController@insert_coupon_code');

//Cart
Route::post('/update-cart-quantity','CartController@update_cart_quantity');
Route::post('/update-cart','CartController@update_cart');
Route::post('/save-cart','CartController@save_cart');
Route::post('/add-cart-ajax','CartController@add_cart_ajax');
Route::get('/show-cart','CartController@show_cart');
Route::get('/gio-hang','CartController@gio_hang');
Route::get('/delete-to-cart/{rowId}','CartController@delete_to_cart');
Route::get('/del-product/{session_id}','CartController@delete_product');
Route::get('/del-all-product','CartController@delete_all_product');
Route::get('/show-cart','CartController@show_cart_menu');

//Checkout
Route::get('/dang-nhap','CheckoutController@login_checkout');
Route::get('/del-fee','CheckoutController@del_fee');

Route::get('/logout-checkout','CheckoutController@logout_checkout');
Route::post('/add-customer','CheckoutController@add_customer');
Route::post('/order-place','CheckoutController@order_place');
Route::post('/login-customer','CheckoutController@login_customer');
Route::get('/checkout','CheckoutController@checkout');
Route::get('/payment','CheckoutController@payment');
Route::post('/save-checkout-customer','CheckoutController@save_checkout_customer');
Route::post('/calculate-fee','CheckoutController@calculate_fee');
Route::post('/select-delivery-home','CheckoutController@select_delivery_home');
Route::post('/confirm-order','CheckoutController@confirm_order');

//Order
Route::post('/delete-order','OrderController@order_code');
Route::get('/print-order/{checkout_code}','OrderController@print_order');
Route::get('/manage-order','OrderController@manage_order');
Route::get('/view-order/{order_code}','OrderController@view_order');
Route::post('/update-order-qty','OrderController@update_order_qty');
Route::post('/update-qty','OrderController@update_qty');


//Delivery
Route::get('/delivery','DeliveryController@delivery');
Route::post('/select-delivery','DeliveryController@select_delivery');
Route::post('/insert-delivery','DeliveryController@insert_delivery');
Route::post('/select-feeship','DeliveryController@select_feeship');
Route::post('/update-delivery','DeliveryController@update_delivery');

//Banner
Route::get('/manage-slider','SliderController@manage_slider');
Route::get('/add-slider','SliderController@add_slider');
Route::get('/delete-slide/{slide_id}','SliderController@delete_slide');
Route::post('/insert-slider','SliderController@insert_slider');
Route::get('/unactive-slide/{slide_id}','SliderController@unactive_slide');
Route::get('/active-slide/{slide_id}','SliderController@active_slide');


//Authentication
Route::get('/register-auth','AuthController@register_auth');
Route::get('/login-auth','AuthController@login_auth');
Route::get('/logout-auth','AuthController@logout_auth');
Route::post('/register','AuthController@register');
Route::post('/login','AuthController@login');