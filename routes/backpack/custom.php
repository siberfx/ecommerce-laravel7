<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('address', 'AddressCrudController');
    Route::crud('attribute', 'AttributeCrudController');
    Route::crud('attributeset', 'AttributeSetCrudController');
    Route::crud('attributevalue', 'AttributeValueCrudController');
    Route::crud('carrier', 'CarrierCrudController');
    Route::crud('cartrule', 'CartRuleCrudController');
    Route::crud('category', 'CategoryCrudController');
    Route::crud('company', 'CompanyCrudController');
    Route::crud('country', 'CountryCrudController');
    Route::crud('currency', 'CurrencyCrudController');
    Route::crud('notificationtemplate', 'NotificationTemplateCrudController');
    Route::crud('order', 'OrderCrudController');
    Route::crud('orderstatus', 'OrderStatusCrudController');
    Route::crud('orderstatushistory', 'OrderStatusHistoryCrudController');
    Route::crud('product', 'ProductCrudController');
    Route::crud('productgroup', 'ProductGroupCrudController');
    Route::crud('productimage', 'ProductImageCrudController');
    Route::crud('specificprice', 'SpecificPriceCrudController');
    Route::crud('tax', 'TaxCrudController');
}); // this should be the absolute last line of this file