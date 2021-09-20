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
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->post("/login", "Home::login");

$routes->group("admin", function ($routes) {
    $routes->get("", 'Admin::index', ["as" => "admin.panel"]);
    $routes->post("kelas_create", 'Admin::kelas_create', ["as" => "admin.kelas.create"]);
    $routes->post("kelas_update", 'Admin::kelas_update', ["as" => "admin.kelas.update"]);
    $routes->post("kelas_delete", 'Admin::kelas_delete', ["as" => "admin.kelas.delete"]);
    $routes->post("kelas_update_password", 'Admin::kelas_update_password', ["as" => "admin.kelas.update.password"]);

    $routes->get("kelas/(:num)", 'Admin::kelas_manage/$1', ["as" => "admin.kelas.manage.siswa"]);
    $routes->post("kelas/(:num)/siswa_create", 'Admin::siswa_create/$1', ["as" => "admin.kelas.manage.siswa.create"]);
    $routes->post("kelas/siswa_update", 'Admin::siswa_update', ["as" => "admin.kelas.manage.siswa.update"]);
    $routes->post("kelas/siswa_delete", 'Admin::siswa_delete', ["as" => "admin.kelas.manage.siswa.delete"]);

    $routes->get("tanggal", 'Admin::tanggal', ["as" => "admin.panel.tanggal"]);
    $routes->post("tanggal/generate", 'Admin::tanggal_generate', ["as" => "admin.panel.tanggal.generate"]);
    $routes->post("tanggal/delete", 'Admin::tanggal_delete', ["as" => "admin.panel.tanggal.delete"]);
});

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
