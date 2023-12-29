<?php

/**
 * Use this file to register routes.
 * 
 * You can use functions and controllers.
 * e.g. Route::addFn('myroute', fn() => view('myview'));
 *      Route::addController('mysecondroute', new MyController());
 */

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Framework\Routing\Router;

Router::addFn('', fn() => view('home'));
Router::addFn('about', fn() => view('about'));
Router::addFn('imprint', fn() => view('imprint'));

Router::addFn('login', fn() => view('login'));
Router::addController('login', new LoginController(), 'POST');

// TODO only if logged in
// TODO only if is admin
// TODO middelware / role check
Router::addModel('product', new ProductController());
Router::addModel('user', new UserController());

Router::pathNotFound(function ($path) { echo 'cannot find path "' . $path. '"'; });
