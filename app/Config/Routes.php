<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
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

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.


$routes->get('/',                      'ProductInOut::product_inout_form');
$routes->post('inout/getdata',         'ProductInOut::get_inout_data');
$routes->post('inout/postdata',        'ProductInOut::postData');
$routes->post('inout/postsubmit',      'ProductInOut::postsubmit');

$routes->get('edit/(:any)',            'ProductInOut::edit/$1');
$routes->post('product_inout/(:any)',  'ProductInOut::product_inout/$1');
$routes->get('delete/(:any)',          'ProductInOut::delete/$1');

$routes->get('product_inout_dtable',   'ProductInOut::product_inout_dtable');

$routes->get('invoice',   'ProductInOut::invoice');

$routes->get('getProducts',            'ProductInOut::getProducts');

$routes->get('in/(:any)',              'ProductInOut::product_in_form/$1');
$routes->get('out/(:any)',             'ProductInOut::product_out_form/$1');


// $routes->get('/',                       'Home::index');
$routes->post('getdata',                'Home::get_data');
$routes->post('postdata',               'Home::postData');
$routes->post('postsubmit',             'Home::postsubmit');

$routes->get('edit/(:any)',             'Home::edit/$1');
$routes->post('update/(:any)',          'Home::update/$1');
$routes->get('delete/(:any)',           'Home::delete/$1');

$routes->get('product_list_dtable',     'Home::product_list_dtable');




// $routes->get('product_add', 'ProductIn::postData');





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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
