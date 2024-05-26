<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// GET
$routes->get('/', 'HalamanUtama::redirect');
$routes->get('/home', 'HalamanUtama::index', ['as' => 'home']);
$routes->get('/forum/(:num)/(:segment)', 'ParentsController::index/$1/$2', ['as' => 'parents']);
$routes->get('/forum/(:num)/(:any)/(:segment)', 'SubparentsController::index/$1/$2/$3', ['as' => 'subparents']);
$routes->get('/thread/(:num)/(:any)/(:segment)', 'ThreadsController::index/$1/$2/$3', ['as' => 'threads']);
$routes->get('/login', 'UserController::index');
$routes->get('/register', 'UserController::halRegister');
$routes->get('/logout', 'UserController::logout', ['as' => 'logout']);

// POST
$routes->post('/login', 'UserController::login', ['as' => 'masuk']);
$routes->post('/register', 'UserController::register', ['as' => 'register']);
$routes->post('/home/createCategory', 'CategoryController::createCategory', ['as' => 'post.category']);
$routes->post('/home/createParents', 'ParentsController::createParents', ['as' => 'post.parents']);
$routes->post('/home/createSubparents/(:num)', 'SubparentsController::createSubparents/$1', ['as' => 'post.subparents']);
$routes->post('/home/createThreads/(:num)/(:num)', 'ThreadsController::createThreads/$1/$2', ['as' => 'post.threads']);

// DELETE
$routes->post('/category/delete/(:any)', 'CategoryController::deleteCategory/$1', ['as' => 'delete.category']);
$routes->post('/parents/delete/(:any)', 'ParentsController::deleteParents/$1', ['as' => 'delete.parent']);
$routes->post('/subparents/delete/(:any)', 'SubparentsController::deleteSubparents/$1', ['as' => 'delete.subparent']);
$routes->post('/threads/delete/(:any)', 'ThreadsController::deletethreads/$1', ['as' => 'delete.threads']);

// UPDATE
$routes->post('/threads/edit/(:any)', 'ThreadsController::editThreads/$1', ['as' => 'edit.threads']);
$routes->post('/category/edit/(:any)', 'CategoryController::editCategory/$1', ['as' => 'edit.category']);
$routes->post('/subparents/edit/(:any)', 'SubparentsController::editSubparents/$1', ['as' => 'edit.subparents']);
$routes->post('/parents/edit/(:any)', 'ParentsController::editParents/$1', ['as' => 'edit.parents']);