<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->post('/user_subscribe', 'Home::user_subscribe');
$routes->get('/user_subscribe_verify', 'Home::verify');

$routes->get('/admin', 'Admin\Login::index');
$routes->post('/admin_login_action', 'Admin\Login::login_action');
$routes->get('/admin_logout', 'Admin\Login::logout');
$routes->get('/admin_dashboard', 'Admin\Dashboard::index');

//Attribute_group
$routes->get('/attribute_group', 'Admin\Attribute_group::index');
$routes->get('/attribute_create', 'Admin\Attribute_group::create');
$routes->post('/attribute_create_action', 'Admin\Attribute_group::create_action');
$routes->post('/attribute_update_action', 'Admin\Attribute_group::update_action');
$routes->get('/attribute_update/(:num)', 'Admin\Attribute_group::update/$1');
$routes->get('/attribute_delete/(:num)', 'Admin\Attribute_group::delete/$1');

//Brand
$routes->get('/brand', 'Admin\Brand::index');
$routes->get('/brand_create', 'Admin\Brand::create');
$routes->post('/brand_create_action', 'Admin\Brand::create_action');
$routes->post('/brand_update_action', 'Admin\Brand::update_action');
$routes->get('/brand_update/(:num)', 'Admin\Brand::update/$1');
$routes->get('/brand_delete/(:num)', 'Admin\Brand::delete/$1');

//Color_family
$routes->get('/color_family', 'Admin\Color_family::index');
$routes->get('/color_family_create', 'Admin\Color_family::create');
$routes->post('/color_family_create_action', 'Admin\Color_family::create_action');
$routes->post('/color_family_update_action', 'Admin\Color_family::update_action');
$routes->get('/color_family_update/(:num)', 'Admin\Color_family::update/$1');
$routes->get('/color_family_delete/(:num)', 'Admin\Color_family::delete/$1');

//Product_category
$routes->get('/product_category', 'Admin\Product_category::index');
$routes->get('/product_category_create', 'Admin\Product_category::create');
$routes->post('/product_category_create_action', 'Admin\Product_category::create_action');
$routes->post('/product_category_update_action', 'Admin\Product_category::update_action');
$routes->post('/product_category_update_action_others', 'Admin\Product_category::update_action_others');
$routes->get('/product_category_update/(:num)', 'Admin\Product_category::update/$1');
$routes->get('/product_category_delete/(:num)', 'Admin\Product_category::delete/$1');

$routes->post('/product_category_sort_update_action', 'Admin\Product_category::sort_update_action');

//Products
$routes->get('/products', 'Admin\Products::index');
$routes->get('/product_create', 'Admin\Products::create');
$routes->post('/product_create_action', 'Admin\Products::create_action');
$routes->post('/product_copy_action', 'Admin\Products::copy_action');
$routes->post('/product_update_action', 'Admin\Products::update_action');
$routes->post('/product_image_delete', 'Admin\Products::image_delete');
$routes->get('/product_update/(:num)', 'Admin\Products::update/$1');
$routes->post('/product_delete', 'Admin\Products::delete');
$routes->get('/related_product', 'Admin\Products::related_product');
$routes->post('/product_option_search', 'Admin\Products::product_option_search');
$routes->post('/product_option_value_search', 'Admin\Products::product_option_value_search');

$routes->post('/product_image_crop_action', 'Admin\Products::image_crop');
$routes->post('/product_multi_delete_action', 'Admin\Products::multi_delete_action');
$routes->post('/remove_cropped_images_action', 'Admin\Products::removeCroppedImagesAction');

$routes->post('/product_image_sort_action', 'Admin\Products::product_image_sort_action');

$routes->get('/products_list', 'Admin\Products::products_list');

$routes->post('product_status_update', 'Admin\Products::status_update');
$routes->post('product_status_update_action', 'Admin\Products::status_update_action');

//Album
$routes->get('/album', 'Admin\Album::index');
$routes->get('/album_create', 'Admin\Album::create');
$routes->post('/album_create_action', 'Admin\Album::create_action');
$routes->post('/album_update_action', 'Admin\Album::update_action');
$routes->get('/album_update/(:num)', 'Admin\Album::update/$1');
$routes->get('/album_delete/(:num)', 'Admin\Album::delete/$1');
$routes->post('/album_image_sort_action', 'Admin\Album::album_image_sort_action');
$routes->post('/album_image_delete', 'Admin\Album::image_delete');

$routes->get('/album_category_create', 'Admin\Album::album_category_create');
$routes->post('/album_category_create_action', 'Admin\Album::album_category_create_action');
$routes->get('/album_category_update/(:num)', 'Admin\Album::album_category_update/$1');
$routes->post('/album_category_update_action', 'Admin\Album::album_category_update_action');
$routes->get('/album_sub_category_list/(:num)', 'Admin\Album::album_sub_category_list/$1');
$routes->get('/album_list/(:num)', 'Admin\Album::album_list/$1');
$routes->get('/album_category_delete/(:num)', 'Admin\Album::album_category_delete/$1');
$routes->post('/album_bulk_update_action', 'Admin\Album::bulk_update_action');
$routes->post('/album_download_action', 'Admin\Album::album_download_action');
$routes->post('/remove_album_cropped_images_action', 'Admin\Album::removeAlbumCroppedImagesAction');


//User
$routes->get('/user', 'Admin\User::index');
$routes->get('/user_create', 'Admin\User::create');
$routes->post('/user_create_action', 'Admin\User::create_action');
$routes->post('/user_update_action', 'Admin\User::update_action');
$routes->post('/user_general_action', 'Admin\User::general_action');
$routes->post('/user_image_action', 'Admin\User::image_action');
$routes->get('/user_update/(:num)', 'Admin\User::update/$1');
$routes->get('/user_delete/(:num)', 'Admin\User::delete/$1');

//Role
$routes->get('/role', 'Admin\Role::index');
$routes->get('/role_create', 'Admin\Role::create');
$routes->post('/role_create_action', 'Admin\Role::create_action');
$routes->post('/role_update_action', 'Admin\Role::update_action');
$routes->get('/role_update/(:num)', 'Admin\Role::update/$1');
$routes->get('/role_delete/(:num)', 'Admin\Role::delete/$1');

//Customers
$routes->get('/customers', 'Admin\Customers::index');
$routes->get('/customers_create', 'Admin\Customers::create');
$routes->post('/customers_create_action', 'Admin\Customers::create_action');
$routes->post('/customers_update_action', 'Admin\Customers::update_action');
$routes->post('/customers_general_action', 'Admin\Customers::general_action');
$routes->get('/customers_update/(:num)', 'Admin\Customers::update/$1');
$routes->get('/customers_delete/(:num)', 'Admin\Customers::delete/$1');
$routes->get('/customers_ledger/(:num)', 'Admin\Customers::ledger/$1');
$routes->get('customers_point/(:num)', 'Admin\Customers::point/$1');


// founds request
$routes->get('/fund_request', 'Admin\Fund_request::index');
$routes->post('/fund_request_action', 'Admin\Fund_request::fund_action');

//Settings
$routes->get('/settings', 'Admin\Settings::index');
$routes->post('/settings_update_action', 'Admin\Settings::update_action');
$routes->get('/cache_image_remove', 'Admin\Settings::cacheImageRemove');


//Shipping
$routes->get('/shipping', 'Admin\Shipping\Shipping::index');

$routes->get('/shipping_settings/(:num)', 'Admin\Shipping\Shipping::shipping_settings/$1');
$routes->post('/shipping_update_action', 'Admin\Shipping\Shipping::update_action');
$routes->post('/update_shipping_status', 'Admin\Shipping\Shipping::update_status');
$routes->post('/remove_settings_weight', 'Admin\Shipping\Shipping::remove_settings_weight');


$routes->post('/zone_rate_update_action', 'Admin\Shipping\Shipping::zone_rate_update_action');
$routes->post('/zone_rate_delete', 'Admin\Shipping\Shipping::zone_rate_delete');


//Payment method
$routes->get('/payment', 'Admin\Payment\Payment::index');
$routes->post('/payment_status_update', 'Admin\Payment\Payment::status_update');

$routes->get('/cash_on/(:num)', 'Admin\Payment\Cash_on_delivery::settings/$1');
$routes->post('/cash_on_update_action', 'Admin\Payment\Cash_on_delivery::update_action');

$routes->get('/bank_transfer/(:num)', 'Admin\Payment\Bank_transfer::bank_settings/$1');
$routes->post('/bank_transfer_update_action', 'Admin\Payment\Bank_transfer::update_action');

$routes->get('/paypal/(:num)', 'Admin\Payment\Paypal::settings/$1');
$routes->post('/paypal_update_action', 'Admin\Payment\Paypal::update_action');

$routes->get('/western_union/(:num)', 'Admin\Payment\Western_union::settings/$1');
$routes->post('/western_union_update_action', 'Admin\Payment\Western_union::update_action');

$routes->get('/moneyGram/(:num)', 'Admin\Payment\MoneyGram::settings/$1');
$routes->post('/moneyGram_update_action', 'Admin\Payment\MoneyGram::update_action');

$routes->get('/bitcoin/(:num)', 'Admin\Payment\Bitcoin::settings/$1');
$routes->post('/bitcoin_update_action', 'Admin\Payment\Bitcoin::update_action');

$routes->get('/credit_card/(:num)', 'Admin\Payment\Credit_card::settings/$1');
$routes->post('/credit_card_update_action', 'Admin\Payment\Credit_card::update_action');

$routes->get('/u_wallet/(:num)', 'Admin\Payment\U_wallet::settings/$1');
$routes->post('/u_wallet_update_action', 'Admin\Payment\U_wallet::update_action');

$routes->get('/oisbizcraft/(:num)', 'Admin\Payment\Oisbizcraft::settings/$1');
$routes->post('oisbizcraft_update_action', 'Admin\Payment\Oisbizcraft::update_action');



//Ajax
$routes->get('/page_list', 'Admin\Page_settings::index');
$routes->get('/page_create', 'Admin\Page_settings::create');
$routes->get('/page_update/(:num)', 'Admin\Page_settings::update/$1');
$routes->get('/page_delete/(:num)', 'Admin\Page_settings::delete/$1');
$routes->post('/page_create_action', 'Admin\Page_settings::create_action');
$routes->post('/page_update_action', 'Admin\Page_settings::update_action');

//Coupon
$routes->get('/coupon', 'Admin\Coupon::index');
$routes->get('/coupon_create', 'Admin\Coupon::create');
$routes->post('/coupon_create_action', 'Admin\Coupon::create_action');
$routes->post('/coupon_update_action', 'Admin\Coupon::update_action');
$routes->get('/coupon_update/(:num)', 'Admin\Coupon::update/$1');
$routes->get('/coupon_delete/(:num)', 'Admin\Coupon::delete/$1');

//Coupon
$routes->get('/general_offer', 'Admin\General_offer::index');
$routes->get('/general_offer_create', 'Admin\General_offer::create');
$routes->post('/general_offer_create_action', 'Admin\General_offer::create_action');
$routes->post('/general_offer_update_action', 'Admin\General_offer::update_action');
$routes->get('/general_offer_update/(:num)', 'Admin\General_offer::update/$1');
$routes->get('/general_offer_delete/(:num)', 'Admin\General_offer::delete/$1');

$routes->get('/zone_based_offer', 'Admin\Zone_based_offer::index');
$routes->get('/zone_based_offer_create', 'Admin\Zone_based_offer::create');
$routes->post('/zone_based_offer_create_action', 'Admin\Zone_based_offer::create_action');
$routes->post('/zone_based_offer_update_action', 'Admin\Zone_based_offer::update_action');
$routes->get('/zone_based_offer_update/(:num)', 'Admin\Zone_based_offer::update/$1');
$routes->get('/zone_based_offer_delete/(:num)', 'Admin\Zone_based_offer::delete/$1');

//
$routes->get('/module', 'Admin\Module::index');
$routes->post('/module_update_action', 'Admin\Module::update_action');
$routes->post('/module_update', 'Admin\Ajax::module_update');
$routes->get('/module_settings/(:num)', 'Admin\Module::module_settings/$1');
$routes->post('/module_settings_action', 'Admin\Module::module_settings_action');

//
$routes->get('/newsletter', 'Admin\Newsletter::index');

$routes->get('/option', 'Admin\Option::index');
$routes->get('/option_create', 'Admin\Option::create');
$routes->post('/option_create_action', 'Admin\Option::create_action');
$routes->post('/option_update_action', 'Admin\Option::update_action');
$routes->get('/option_update/(:num)', 'Admin\Option::update/$1');
$routes->get('/option_delete/(:num)', 'Admin\Option::delete/$1');
$routes->post('/option_remove_action', 'Admin\Option::option_remove_action');

//Coupon
$routes->get('/order_list', 'Admin\Order::index');
$routes->post('/order_history_action', 'Admin\Order::history_action');
$routes->get('/order_view/(:num)', 'Admin\Order::order_view/$1');
$routes->post('/order_payment_status_action', 'Admin\Order::payment_status_action');
$routes->post('order_point_action', 'Admin\Order::point_action');

//Theme Settings
$routes->get('/theme_settings', 'Admin\Theme_settings::index');
$routes->post('/slider_update', 'Admin\Theme_settings::slider_update');
$routes->post('/logo_update', 'Admin\Theme_settings::logo_update');
$routes->post('/favicon_update', 'Admin\Theme_settings::favicon_update');
$routes->post('/home_category', 'Admin\Theme_settings::home_category');
$routes->post('/home_category_banner', 'Admin\Theme_settings::home_category_banner');
$routes->post('/settings_update', 'Admin\Theme_settings::settings_update');
$routes->post('/home_special_banner', 'Admin\Theme_settings::home_special_banner');
$routes->post('/home_left_side_banner', 'Admin\Theme_settings::home_left_side_banner');

$routes->post('/header_section_one_update', 'Admin\Theme_settings_3::header_section_one_update');
$routes->post('/header_section_two_update', 'Admin\Theme_settings_3::header_section_two_update');
$routes->post('/home_category_update', 'Admin\Theme_settings_3::home_category_update');
$routes->post('/banner_bottom_update', 'Admin\Theme_settings_3::banner_bottom_update');
$routes->post('/banner_featured_category_update', 'Admin\Theme_settings_3::banner_featured_category_update');
$routes->post('/banner_top_update', 'Admin\Theme_settings_3::banner_top_update');

//Localization
$routes->get('/geo_zone', 'Admin\Geo_zone::index');
$routes->get('/geo_zone_create', 'Admin\Geo_zone::create');
$routes->post('/geo_zone_create_action', 'Admin\Geo_zone::create_action');
$routes->get('/geo_zone_update/(:num)', 'Admin\Geo_zone::update/$1');
$routes->post('/geo_zone_update_action', 'Admin\Geo_zone::update_action');
$routes->get('/geo_zone_delete/(:num)', 'Admin\Geo_zone::delete/$1');
$routes->post('/geo_zone_detail_delete', 'Admin\Geo_zone::geo_zone_detail_delete');

//Email_send
$routes->get('/email_send', 'Admin\Email_send::index');
$routes->post('/email_send_action', 'Admin\Email_send::email_send_action');

//Reviews
$routes->get('/reviews', 'Admin\Reviews::index');
$routes->post('/reviews_status_update', 'Admin\Reviews::reviews_status_update');
$routes->get('/reviews_delete/(:num)', 'Admin\Reviews::delete/$1');

//Advanced Products routes
$routes->get('/bulk_edit_products', 'Admin\Advanced_products::index');
$routes->post('/bulk_status_update', 'Admin\Advanced_products::bulk_status_update');
$routes->post('/bulk_data_update', 'Admin\Advanced_products::bulk_data_update');
$routes->post('/description_data_update', 'Admin\Advanced_products::description_data_update');
$routes->post('/bulk_all_status_update', 'Admin\Advanced_products::bulk_all_status_update');
$routes->post('/bulk_category_view', 'Admin\Advanced_products::bulk_category_view');
$routes->post('/bulk_category_update', 'Admin\Advanced_products::bulk_category_update');

$routes->post('/bulk_product_cpoy', 'Admin\Advanced_products::bulk_product_cpoy');

$routes->post('/bulk_option_view', 'Admin\Advanced_products::bulk_option_view');
$routes->post('/bulk_option_update', 'Admin\Advanced_products::bulk_option_update');

$routes->post('/bulk_product_multi_delete', 'Admin\Advanced_products::product_multi_delete');
$routes->post('/bulk_product_multi_option_edit', 'Admin\Advanced_products::multi_option_edit');
$routes->post('/bulk_multi_option_action', 'Admin\Advanced_products::multi_option_action');

$routes->post('/bulk_product_multi_attribute_edit', 'Admin\Advanced_products::multi_attribute_edit');
$routes->post('/bulk_multi_attribute_action', 'Admin\Advanced_products::multi_attribute_action');

$routes->post('/bulk_product_multi_category_edit', 'Admin\Advanced_products::multi_category_edit');
$routes->post('/bulk_multi_category_action', 'Admin\Advanced_products::multi_category_action');

$routes->post('/product_image_show_action', 'Admin\Advanced_products::image_show');

$routes->post('/bulk_product_multi_price_edit', 'Admin\Advanced_products::multi_price_edit');
$routes->post('/bulk_product_multi_price_action', 'Admin\Advanced_products::multi_price_action');

$routes->post('/bulk_related_action', 'Admin\Advanced_products::bulk_related_action');
$routes->post('/bulk_bought_together_action', 'Admin\Advanced_products::bulk_bought_together_action');

$routes->get('/bulk_product_list', 'Admin\Advanced_products::product_list');

$routes->post('/image_download_action', 'Admin\Advanced_products::image_download_action');
$routes->get('/multi_related_product', 'Admin\Advanced_products::multiRelatedProduct');
$routes->post('/multi_related_product_action', 'Admin\Advanced_products::multiRelatedProductAction');
$routes->post('/bulk_info_updater', 'Admin\Advanced_products::bulkInfoUpdater');
$routes->post('/bulk_info_updater_action', 'Admin\Advanced_products::bulkInfoUpdaterAction');

$routes->get('blog_category', 'Admin\Blog_category::index');
$routes->get('blog_category_create', 'Admin\Blog_category::create');
$routes->post('blog_category_create_action', 'Admin\Blog_category::createAction');
$routes->post('blog_category_update_action', 'Admin\Blog_category::updateAction');
$routes->post('blog_category_update_action_others', 'Admin\Blog_category::updateActionOthers');
$routes->get('blog_category_update/(:num)', 'Admin\Blog_category::update/$1');
$routes->get('blog_category_delete/(:num)', 'Admin\Blog_category::delete/$1');
$routes->post('blog_category_sort_update_action', 'Admin\Blog_category::sortUpdateAction');

//blog
$routes->get('admin-blog', 'Admin\Blog::index');
$routes->get('blog_create', 'Admin\Blog::create');
$routes->post('blog_create_action', 'Admin\Blog::createAction');
$routes->post('blog_update_action', 'Admin\Blog::updateAction');
$routes->get('blog_update/(:num)', 'Admin\Blog::update/$1');
$routes->get('blog_delete/(:num)', 'Admin\Blog::delete/$1');
$routes->post('blog_image_remove_action', 'Admin\Blog::imageRemoveAction');

//login routes
$routes->get('/register', 'Login::register');
$routes->get('/login', 'Login::index');
$routes->post('/login_action', 'Login::login_action');
$routes->post('/register_action', 'Login::register_action');
$routes->get('/logout', 'Login::logout');
$routes->get('/forgotpassword', 'Login::forgotPassword');
$routes->post('/password_action', 'Login::password_action');
$routes->get('/otp_submit', 'Login::otp_submit');
$routes->post('/otp_action', 'Login::otp_action');
$routes->get('/password_reset', 'Login::password_reset');
$routes->post('/reset_action', 'Login::reset_action');


//Customer Dashboard routes
$routes->get('/dashboard', 'Customer\Dashboard::index');
$routes->post('/addtoWishlist', 'Customer\Dashboard::addtoWishlist');


$routes->get('/favorite', 'Customer\Favorite::index');
$routes->post('/removeToWishlist', 'Customer\Favorite::removeToWishlist');
$routes->get('/my_order', 'Customer\Order::index');
$routes->get('/invoice/(:num)', 'Customer\Order::invoice/$1');

$routes->get('/profile', 'Customer\Profile::index');
$routes->post('/profile_update_action', 'Customer\Profile::update_action');
$routes->post('/password_action_update', 'Customer\Profile::password_action');
$routes->post('/newsletter_action', 'Customer\Profile::newsletter_action');


$routes->get('/my_wallet', 'Customer\Wallet::index');
$routes->get('/add_funds', 'Customer\Wallet::add_funds');
$routes->post('/add_funds_action', 'Customer\Wallet::fund_action');

$routes->get('/ledger', 'Customer\Customer_ledger::index');
$routes->get('/point_history', 'Customer\Customer_point_history::index');


//cart routes
$routes->get('/cart', 'Cart\Cart::index');
$routes->post('/checkoption', 'Cart\Cart::checkoption');
$routes->post('/addtocart', 'Cart\Cart::addToCart');
$routes->post('/addtocartdetail', 'Cart\Cart::addtocartdetail');
$routes->post('/addtocartgroup', 'Cart\Cart::addToCartGroup');
$routes->post('/updateToCart', 'Cart\Cart::updateToCart');
$routes->post('/removeToCart', 'Cart\Cart::removeToCart');
$routes->get('/cart_empty_check', 'Cart\Cart::cart_empty_check');

//Checkout
$routes->get('/checkout', 'Checkout::index');
$routes->post('/checkout_coupon_action', 'Checkout::coupon_action');
$routes->post('/checkout_action', 'Checkout::checkout_action');
$routes->post('/checkout_country_zoon', 'Checkout::country_zoon');
$routes->post('/flat_shipping_rate', 'Checkout::flat_shipping_rate');
$routes->post('/zone_shipping_rate', 'Checkout::zone_shipping_rate');
$routes->post('/shipping_rate', 'Checkout::shipping_rate');

$routes->get('/checkout_success', 'Checkout::success');
$routes->get('/checkout_failed', 'Checkout::failed');
$routes->get('/checkout_canceled', 'Checkout::canceled');

$routes->post('/payment_instruction', 'Checkout::payment_instruction');

$routes->get('/payment_paypal', 'Paypal::index');
$routes->get('/payment_paypal_checkout_action', 'Paypal::paypal_checkout_action');

$routes->post('/payment_stripe', 'StripeController::payment_stripe');
$routes->post('/payment_stripe_checkout_action', 'StripeController::stripe_create_charge');
$routes->get('/stripe_action', 'StripeController::stripe_action');

$routes->post('/payment_oisbizcraft', 'OisbizcraftController::payment_oisbizcraft');
$routes->get('/oisbizcraft-return-url', 'OisbizcraftController::return_url');
$routes->get('/oisbizcraft_action', 'OisbizcraftController::oisbizcraft_action');
$routes->post('/oisbizcraft-notification', 'OisbizcraftController::notification_webhook');
$routes->get('/oisbizcraft-success', 'OisbizcraftController::success');

$routes->get('stripe/(:num)', 'Admin\Payment\Stripe::settings/$1');
$routes->post('stripe_update_action', 'Admin\Payment\Stripe::update_action');

//pages routes
$routes->get('/about', 'Pages\Pages::about');
$routes->get('/contact', 'Pages\Pages::contact');
$routes->post('/contact_form_action', 'Pages\Pages::contact_action');
$routes->get('/page/(:any)', 'Pages\Pages::page/$1');

//products routes
$routes->get('/detail/(:num)', 'Products\Products::detail/$1');
$routes->get('/product-not-found', 'Products\Products::product_not_found');
$routes->post('/review', 'Products\Products::review');
$routes->post('/both_product_price', 'Products\Products::both_product_price');
$routes->post('/optionPriceCalculate', 'Products\Products::optionPriceCalculate');

$routes->get('/featuredproducts', 'Featuredproducts::index');


//Compare
$routes->get('/compare', 'Compare::index');
$routes->post('/addtoCompare', 'Compare::addtoCompare');
$routes->post('/removeToCompare', 'Compare::removeToCompare');

//Category
$routes->get('/category/(:num)', 'Category::index/$1');
$routes->Post('/category_url_generate', 'Category::url_generate');
$routes->get('/category-not-found', 'Category::categoryNotFound');

//Search top
$routes->post('/top_search', 'Search::search_action');

//Qc picture
$routes->get('/qc-picture', 'Album::index');
$routes->get('/qc-picture-view-category/(:num)', 'Album::qc_picture_view_category/$1');
$routes->get('/qc-picture-view/(:num)', 'Album::view/$1');
$routes->post('/qc-picture-query', 'Album::qc_picture_query');
$routes->get('/qc-picture-not-found', 'Album::picture_not_found');

//offers
$routes->get('/offers', 'Offers::index');
$routes->get('/offers-view/(:any)', 'Offers::view/$1');

//ajax controller
$routes->post('/get_state', 'Admin\Ajax::get_state');
$routes->post('/get_zone_value', 'Admin\Ajax::get_zone_value');

$routes->get('/image-resize/(:any)/(:any)/(:any)', 'Image::resize/$1/$2/$3');

//Blog
$routes->get('/blog', 'Blog::index');
$routes->get('/blog-category/(:num)', 'Blog::category/$1');
$routes->get('/blog-view/(:num)', 'Blog::view/$1');
$routes->post('/blog-comment-action', 'Blog::commentAction');
$routes->post('/blog-comment-reply-action', 'Blog::commentReplyAction');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}