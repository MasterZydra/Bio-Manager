<?php

/**
 * Use this file to register routes.
 * 
 * You can use functions and controllers.
 * e.g. Route::addFn('myroute', fn() => view('myview'));
 *      Route::addController('mysecondroute', new MyController());
 */

use App\Http\Controllers\DeliveryNoteController;
use App\Http\Controllers\EditVolumeDistributionController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PlotController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RecipientController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\User\ChangePasswordController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\LogoutController;
use App\Http\Controllers\UserController;
use Framework\Authentication\Auth;
use Framework\Cli\Controllers\WebCliController;
use Framework\Facades\Http;
use Framework\Routing\Router;

if (!Auth::isLoggedIn()) {
    Router::addFn('', fn() => view('home'));
} else {
    Router::addFn('', fn() => view('auth.home'));
}

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

    Router::addModel('deliveryNote', new DeliveryNoteController());
    Router::addModel('invoice', new InvoiceController());
    Router::addModel('plot', new PlotController());
    Router::addModel('price', new PriceController());
    Router::addModel('product', new ProductController());
    Router::addModel('recipient', new RecipientController());
    Router::addModel('supplier', new SupplierController());
    Router::addModel('user', new UserController());
    Router::addController('volumeDistribution/edit', new EditVolumeDistributionController());
    Router::addController('volumeDistribution/edit', new EditVolumeDistributionController(), 'POST');
}

// TODO only if is admin

Router::pathNotFound(fn() => Http::redirect('/'));
