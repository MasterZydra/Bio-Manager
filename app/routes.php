<?php

/**
 * Use this file to register routes.
 * 
 * You can use functions and controllers.
 * e.g. Route::addFn('myroute', fn() => view('myview'));
 *      Route::addController('mysecondroute', new MyController());
 */

use App\Http\Controllers\LoginController;
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
Router::addResource('user', new UserController());

Router::pathNotFound(function ($path) { echo 'cannot find path "' . $path. '"'; });

// TODO add to documentation
// Router::addController('user/create', new TestController()); // form for new resource
// Router::addController('user/store', new TestController()); // store new resource
// Router::addController('user/edit', new TestController()); // show form for editing
// Router::addController('user/update', new TestController()); // store the edit changes
// Router::addController('user/destroy', new TestController()); // remove resource
// Router::addController('user/index', new TestController()); // List the resources
// index(), create(), store($model), show($id), edit($id), update($request, id), destory(id)
