<?php

/**
 * Use this file to register routes.
 * 
 * You can use functions and controllers.
 * e.g. Route::addFn('myroute', fn() => view('myview'));
 *      Route::addController('mysecondroute', new MyController());
 */

use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\ChangePasswordController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\LogoutController;
use App\Http\Controllers\UserController;
use Framework\Authentication\Auth;
use Framework\Cli\Controllers\WebCliController;
use Framework\Facades\Http;
use Framework\Routing\Router;

    Router::addFn('', fn() => view('home'));
Router::addFn('imprint', fn() => view('imprint'));

Router::addFn('login', fn() => view('login'));
Router::addController('login', new LoginController(), 'POST');

if (Auth::isLoggedIn()) {
    Router::addFn('about', fn() => view('about'));

    Router::addFn('changePassword', fn() => view('entities.user.changePassword'));
    Router::addController('changePassword', new ChangePasswordController(), 'POST');
    Router::addController('logout', new LogoutController());

    Router::addController('cli', new WebCliController());
    Router::addController('cli', new WebCliController(), 'POST');

    Router::addModel('product', new ProductController());
    Router::addModel('user', new UserController());
}

// TODO only if is admin

Router::pathNotFound(fn() => Http::redirect('/'));
