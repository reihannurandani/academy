<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

// ================= LOGIN =================
$routes->get('login', 'Auth::login');
$routes->post('proses-login', 'Auth::prosesLogin');
$routes->get('logout', 'Auth::logout');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
$routes->group('admin', ['filter' => ['auth', 'role:admin']], function($routes){

    // Dashboard
    $routes->get('dashboard', 'Admin::index');

    /*
    ================= USERS =================
    */
    $routes->get('users', 'Admin::users');
    $routes->get('create-user', 'Admin::createUser');
    $routes->post('store-user', 'Admin::storeUser');
    $routes->get('edit-user/(:num)', 'Admin::editUser/$1');
    $routes->post('update-user/(:num)', 'Admin::updateUser/$1');
    $routes->get('delete-user/(:num)', 'Admin::deleteUser/$1');


    /*
    ================= CATEGORIES =================
    */
    $routes->get('categories', 'Admin::categories');
    $routes->get('create-category', 'Admin::createCategory');
    $routes->post('store-category', 'Admin::storeCategory');
    $routes->get('edit-category/(:num)', 'Admin::editCategory/$1');
    $routes->post('update-category/(:num)', 'Admin::updateCategory/$1');
    $routes->get('delete-category/(:num)', 'Admin::deleteCategory/$1');


    /*
    ================= PRODUCTS =================
    */
    $routes->get('products', 'Admin::products');
    $routes->get('create-product', 'Admin::createProduct');
    $routes->post('store-product', 'Admin::storeProduct');
    $routes->get('edit-product/(:num)', 'Admin::editProduct/$1');
    $routes->post('update-product/(:num)', 'Admin::updateProduct/$1');
    $routes->get('delete-product/(:num)', 'Admin::deleteProduct/$1');
});


/*
|--------------------------------------------------------------------------
| KASIR
|--------------------------------------------------------------------------
*/
$routes->group('kasir', ['filter'=>['auth','role:kasir']], function($routes){

    $routes->get('dashboard','Kasir::index');

    $routes->get('transaksi','Kasir::transaksi');

    // SAMA PERSIS DENGAN FORM
    $routes->post('saveTransaksi','Kasir::saveTransaksi');

    $routes->get('struk/(:num)','Kasir::struk/$1');
});

/*
|--------------------------------------------------------------------------
| OWNER
|--------------------------------------------------------------------------
*/
$routes->group('owner', ['filter' => ['auth', 'role:owner']], function($routes){

    // Dashboard
    $routes->get('dashboard', 'Owner::index');

    /*
    ================= LAPORAN =================
    */
    $routes->get('laporan', 'Owner::laporan');
    $routes->get('cetak-pdf', 'Owner::cetakPdf'); 

    /*
    ================= LOG ACTIVITY =================
    */
    $routes->get('logs', 'Owner::logActivity');

    /*
    ================= UPDATE STATUS =================
    */
    $routes->post('update-status/(:num)', 'Owner::updateStatus/$1');
});