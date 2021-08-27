<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Dashboard'); // mengatur default controller ketika yg diakses adalah route awal localhost:8080
$routes->setDefaultMethod('index'); //mengatur default method yg diakses. biasanya memang index() [tidak usa diganti yg ini]
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.


// $routes->get('/', 'Dashboard::index');
// jika redirect maka ketika akses localhost:8080 akan eror, maka dari itu routes  $routes->get('/', 'Dashboard::index'); dikomentari
// jadi disini dashboard merupakan alias dari routes localhost:8080 
// localhost:8080 akan otomatis buka dashboard::index karena default controllernya adalah Dashboard
$routes->addRedirect('/', 'dashboard');

$routes->get('supplier', 'Supplier::index');
// routes wajib diisi ketika menggunakan http method spoofing
// routes method request delete (dari http method spoofing), dengan begitu link /komik/(:num) tidak akan terlihat
$routes->delete('supplier/(:num)', 'Supplier::delete/$1');
// routes post/get/delete sesuaikan dengan yg ada di form method
// hanya method get yang bisa diganti linknya/diredirect
$routes->get('buat', 'Supplier::create');
// routes save supplier
$routes->post('supplier/save', 'Supplier::save');
// routes edit supplier
$routes->post('supplier/edit/(:segment)', 'Supplier::edit/$1');
// routes update supplier
$routes->post('supplier/update/(:num)', 'Supplier::update/$1');

// routes create customer
$routes->get('customer/create', 'Customer::create');
// routes save customer
$routes->post('customer/save', 'Customer::save');
// routes hapus customer
$routes->delete('customer/(:num)', 'Customer::delete/$1');

// routes create category
$routes->get('category/create', 'Category::create');
// routes save category
$routes->post('category/save', 'Category::save');
// routes hapus category
$routes->delete('category/(:num)', 'Category::delete/$1');

// routes stock-in
$routes->get('stock/in', 'Stockin::index');
// routes stock-in create
$routes->get('stock/in/add', 'Stockin::create');
// routes hapus stock-in 
$routes->delete('stock/in/del/(:num)/(:num)', 'Stockin::delete/$1/$2');

// routes stock-out
$routes->get('stock/out', 'Stockout::index');
// routes stock-in create
$routes->get('stock/out/add', 'Stockout::create');
// routes hapus stock-in 
$routes->delete('stock/out/del/(:num)/(:num)', 'Stockout::delete/$1/$2');

// routes user
$routes->get('user', 'User::index');
// routes user create
$routes->get('user/add', 'User::create');
// routes hapus user
$routes->delete('user/del/(:num)', 'User::delete/$1');









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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}