<?php
namespace Config;
// Create a new instance of our RouteCollection class.
$routes = Services::routes();
/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
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

// *******************************header route end here**************************
$routes->get('account', 'Header\HeaderController::account_page');

$routes->get('/my-orders', 'Header\HeaderController::my_orders');
$routes->post('/myorders', 'Header\HeaderController::getMyorders');
$routes->post('/myordersitemsview', 'Header\HeaderController::my_orders_itemsview');

$routes->post('/order/refresh_basket', 'Header\HeaderController::refresh_basket');

// *******************************header route end here**************************

/****************************** LOGOUT *****************************/
$routes->get('/logout', 'Header\HeaderController::logout');
/****************************** LOGOUT *****************************/


// *******************************index route start here**************************
$routes->post('/index', 'Order::index');
$routes->get('index', 'Order::index');
$routes->get('order/index', 'Order::index');

//search products index start
$routes->post('search_product_details','Search\SearchController::getSearchedData');
//search products index end
$routes->post('check_product_in_8weeks', 'Search\CheckProductsin8WeeksController::check_pro_in_8weeks');
$routes->post('add_to_cart_index', 'Search\AddToCartController::add_to_cart');
$routes->post('index_cart_append', 'Search\CartAppendController::cart_append');
$routes->post('update_cart', 'Search\UpdateCartController::update_index_cart');
$routes->post('index_delete_cart_item','Search\DeleteProductCartController::delete_cart_item');
$routes->post('check_items_incart', 'Search\MainController::check_items_incart');
$routes->post('check_product_recommended','Search\MainController::check_recomm_product');
$routes->post('create_session_for_currency','Search\MainController::create_session_currency');
// *******************************index route end here**************************

// *******************************more info route start here**************************
$routes->post('more-info', 'MoreInfo\ProductInfoController::more_information');

//$routes->get('more-info', 'MoreInfo\ProductInfoController::more_information');

$routes->post('check_cartproduct_discount', 'MoreInfo\MoreInfoController::check_pro_8Weeks');
$routes->post('add_to_cart', 'Search\AddToCartController::add_to_cart');
$routes->post('addtocart-by-moreinfo','MoreInfo\AddRecommendedProductController::add_to_cart_by_more_info');
$routes->post('recommendedIitem', 'MoreInfo\MoreInfoController::recommended_items');

// *******************************more info route ends here**************************


// my orders route ends here



/******************************cart*****************************************/
$routes->get('/cart', 'Cart\CartController::cart');
$routes->get('/order/cart', 'Cart\CartController::cart');

$routes->post('/order/setsessionpo', 'Cart\SetSessionPoController::set_session_po');
$routes->post('/order/setsessionponewaddr', 'Cart\SetSessionPoController::set_session_po_newship');
$routes->post('/order/unsetshippingsession', 'Cart\SetSessionPoController::unset_cart_sessions');
$routes->post('/order/refreshcart', 'Cart\RefreshCartController::refresh_cart');
$routes->post('/order/getshipaddress', 'Cart\ShippingAddressController::get_ship_address');
$routes->post('/order/getshipaddressinfo', 'Cart\ShippingAddressController::get_ship_address_info');
$routes->post('/order/checkitemsincart', 'Cart\CartController::check_items_incart');
$routes->post('/order/savecartaddress', 'Cart\SaveCartAddressController::save_cart_address');
$routes->post('/order/clearcartitem', 'Cart\CartController::clear_cart_item');
$routes->post('/order/deletecartitem', 'Cart\CartController::delete_cart_item');
$routes->post('order/updatecartitems', 'Cart\UpdateCartItemsController::updatecartitems');
$routes->post('/order/savepreviewdetails', 'Cart\SavePreviewDetailsController::save_preview_details');

/******************************cart end*****************************************/

/******************************perview start*****************************************/
$routes->post('/previeworder', 'Preview\PreviewController::preview_order');
$routes->get('/previeworder', 'Preview\PreviewController::preview_order');
$routes->post('/order/saveorderdetails', 'Preview\PreviewController::save_order_details');
$routes->post('/billprint', 'Preview\PreviewController::billprint');

/******************************perview end*****************************************/


/******************************stock dealer register*****************************/

$routes->post('stock-dealer-registration', 'StockRegister\StockRegisterController::stock_dealer');
$routes->post('save-stock-dealer-registration', 'StockRegister\StockRegisterController::save_stock_dealer');
/******************************stock dealer register*****************************/



$routes->get('help', 'Order::ebms_customer_help');
$routes->get('/test', 'Order::test');




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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) 
{
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}