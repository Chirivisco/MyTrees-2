<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/amigos/register', 'Amigos::registrar');
$routes->post('/amigos/register', 'Amigos::registrar');
$routes->get('/success', 'Amigos::success');

$routes->get('/login', 'LoginController::index');
$routes->post('/login', 'LoginController::login');

$routes->get('/admin/dashboard', 'AdminController::dashboard');
$routes->get('/amigos/dashboard', 'Amigos::dashboard');

$routes->get('arboles/insertarArbol', 'Arboles::insertarArbol');
$routes->post('arboles/insertarArbol', 'Arboles::insertarArbol');






