<?php

declare(strict_types = 1);

/**
 * Use this file to register routes.
 * 
 * You can use functions and controllers.
 * e.g. Route::addFn('myroute', fn() => view('myview'));
 *      Route::addController('mysecondroute', new MyController());
 */

use App\Http\Controllers\ActiveSuppliersController;
use App\Http\Controllers\AmountDevelopmentStatsController;
use App\Http\Controllers\DeliveryNoteController;
use App\Http\Controllers\DeveloperToolsController;
use App\Http\Controllers\EditImprintSettingsController;
use App\Http\Controllers\EditInvoiceSettingsController;
use App\Http\Controllers\EditVolumeDistributionController;
use App\Http\Controllers\FinancialRevenueProfitStatsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OpenVolumeDistributionsController;
use App\Http\Controllers\PlotController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\PriceDevelopmentStatsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RecipientController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierPayoutsController;
use App\Http\Controllers\User\ChangePasswordController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\LogoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VolumeDistributionPdfController;
use Framework\Authentication\Auth;
use Framework\Cli\Controllers\WebCliController;
use Framework\Facades\Http;
use Framework\Routing\Router;

Router::addFn('', fn() => !Auth::isLoggedIn() ? view('home') : view('auth.home'));

Router::addFn('imprint', fn() => view('imprint'));

Router::addFn('login', fn() => view('login'));
Router::addController('login', new LoginController(), 'POST');

if (Auth::isLoggedIn()) {
    Router::addFn('about', fn() => view('about'));

    Router::addFn('changePassword', fn() => view('entities.user.changePassword'));
    Router::addController('changePassword', new ChangePasswordController(), 'POST');
    Router::addController('logout', new LogoutController());

    if (Auth::hasRole('Maintainer')) {
        // Entities
        Router::addController('volumeDistribution/edit', new EditVolumeDistributionController());
        Router::addController('volumeDistribution/edit', new EditVolumeDistributionController(), 'POST');
        Router::addModel('deliveryNote', new DeliveryNoteController());
        Router::addModel('invoice', new InvoiceController());
        Router::addModel('plot', new PlotController());
        Router::addModel('price', new PriceController());
        Router::addModel('product', new ProductController());
        Router::addModel('recipient', new RecipientController());
        Router::addModel('setting', new SettingController());
        Router::addModel('supplier', new SupplierController());

        // Analyses
        Router::addController('activeSuppiers', new ActiveSuppliersController());
        Router::addController('showSupplierPayouts', new SupplierPayoutsController());
        Router::addController('showSupplierPayouts', new SupplierPayoutsController(), 'POST');
        Router::addController('openVolumeDistributions', new OpenVolumeDistributionsController());
        Router::addController('showVolumeDistribution', new VolumeDistributionPdfController());
        Router::addController('showVolumeDistribution', new VolumeDistributionPdfController(), 'POST');
        Router::addController('financialRevenueProfitStats', new FinancialRevenueProfitStatsController());
        Router::addController('amountDevelopmentStats', new AmountDevelopmentStatsController());
        Router::addController('priceDevelopmentStats', new PriceDevelopmentStatsController());
    }

    if (Auth::hasRole('Administrator')) {
        Router::addModel('user', new UserController());

        // Settings
        Router::addController('editImprintSettings', new EditImprintSettingsController());
        Router::addController('editImprintSettings', new EditImprintSettingsController(), 'POST');
        Router::addController('editInvoiceSettings', new EditInvoiceSettingsController());
        Router::addController('editInvoiceSettings', new EditInvoiceSettingsController(), 'POST');
    }

    if (Auth::hasRole('Developer')) {
        Router::addController('devTools', new DeveloperToolsController());
        Router::addController('devTools', new DeveloperToolsController(), 'POST');
        Router::addController('cli', new WebCliController());
        Router::addController('cli', new WebCliController(), 'POST');
    }
}

Router::pathNotFound(fn() => Http::redirect('/'));
