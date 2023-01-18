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
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->add('/', 'Administrator::index', ['filter' => 'auth_administrator']);

$routes->get('/login', 'Login::index', ['filter' => 'auth_login']);
$routes->add('/login/(:any)', 'Login::$1', ['filter' => 'auth_login']);

$routes->get('/administrator', 'Administrator::index', ['filter' => 'auth_administrator']);
$routes->add('/administrator/(:any)', 'Administrator::$1', ['filter' => 'auth_administrator']);

// ========== ADMIN ==========
$routes->get('/admin', 'Admin::index', ['filter' => 'auth_admin']);
$routes->add('/admin/cashier', 'Admin::cashier', ['filter' => 'auth_owner']);
$routes->add('/admin/warehouse', 'Admin::warehouse', ['filter' => 'auth_owner']);
$routes->add('/admin/sq_add', 'Admin::sq_add', ['filter' => 'auth_cashier']);
$routes->add('/admin/pr_add', 'Admin::pr_add', ['filter' => 'auth_warehouse']);
$routes->add('/admin/(:any)', 'Admin::$1', ['filter' => 'auth_admin']);

$routes->get('/{locale}/admin', 'Admin::index', ['filter' => 'auth_admin']);
$routes->add('/{locale}/admin/cashier', 'Admin::cashier', ['filter' => 'auth_owner']);
$routes->add('/{locale}/admin/warehouse', 'Admin::warehouse', ['filter' => 'auth_owner']);
$routes->add('/{locale}/admin/sq_add', 'Admin::sq_add', ['filter' => 'auth_cashier']);
$routes->add('/{locale}/admin/pr_add', 'Admin::pr_add', ['filter' => 'auth_warehouse']);
$routes->add('/{locale}/admin/(:any)', 'Admin::$1', ['filter' => 'auth_admin']);

// ========== RESFULL API ==========
$routes->add('/item/(:any)', 'Item::$1', ['filter' => 'auth_jwt']);

$routes->add('/item_group/(:any)', 'Item_Group::$1', ['filter' => 'auth_jwt']);

$routes->add('/measure/(:any)', 'Measure::$1', ['filter' => 'auth_jwt']);

$routes->add('/sq/(:any)', 'Sq::$1', ['filter' => 'auth_jwt']);

$routes->add('/po/(:any)', 'Po::$1', ['filter' => 'auth_jwt']);

$routes->add('/pr/(:any)', 'Pr::$1', ['filter' => 'auth_jwt']);

$routes->add('/ps/(:any)', 'Ps::$1', ['filter' => 'auth_jwt']);

$routes->add('/return/(:any)', 'Return_::$1', ['filter' => 'auth_jwt']);

$routes->add('/stock/(:any)', 'Stock::$1', ['filter' => 'auth_jwt']);

$routes->add('/suplier/(:any)', 'Suplier::$1', ['filter' => 'auth_jwt']);

$routes->add('/user/(:any)', 'User::$1', ['filter' => 'auth_jwt']);

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
