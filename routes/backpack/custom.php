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
    Route::crud('categories', 'CategoryCrudController');
    Route::crud('currencies', 'CurrencyCrudController');
    Route::crud('carriers', 'CarrierCrudController');
    Route::crud('attribute', 'AttributeCrudController');
    Route::crud('attributes-sets', 'AttributeSetCrudController');
    Route::crud('products', 'ProductCrudController');
    Route::crud('taxes', 'TaxCrudController');
    Route::crud('orders', 'OrderCrudController');
    Route::crud('order-statuses', 'OrderStatusCrudController');
    Route::crud('cart-rules', 'CartRuleCrudController');
    Route::crud('specific-prices', 'SpecificPriceCrudController');
    Route::crud('notification-templates', 'NotificationTemplateCrudController');
    Route::crud('clients', 'ClientCrudController');
    Route::crud('users', 'UserCrudController');
}); // this should be the absolute last line of this file


// Ajax
Route::group(['middleware' => 'admin',
    'prefix' => 'ajax',
    'namespace' => 'Admin'
], function() {
    // Get attributes by set id
    Route::post('attribute-sets/list-attributes', ['as' => 'getAttrBySetId', 'uses' => 'AttributeSetCrudController@ajaxGetAttributesBySetId']);

    // Product images upload routes
    Route::post('product/image/upload', ['as' => 'uploadProductImages', 'uses' => 'ProductCrudController@ajaxUploadProductImages']);
    Route::post('product/image/reorder', ['as' => 'reorderProductImages', 'uses' => 'ProductCrudController@ajaxReorderProductImages']);
    Route::post('product/image/delete', ['as' => 'deleteProductImage', 'uses' => 'ProductCrudController@ajaxDeleteProductImage']);

    // Get group products by group id
    Route::post('product-group/list/products', ['as' => 'getGroupProducts', 'uses' => 'ProductGroupController@getGroupProducts']);
    Route::post('product-group/list/ungrouped-products', ['as' => 'getUngroupedProducts', 'uses' => 'ProductGroupController@getUngroupedProducts']);
    Route::post('product-group/add/product', ['as' => 'addProductToGroup', 'uses' => 'ProductGroupController@addProductToGroup']);
    Route::post('product-group/remove/product', ['as' => 'removeProductFromGroup', 'uses' => 'ProductGroupController@removeProductFromGroup']);

    // Client address
    Route::post('client/list/addresses', ['as' => 'getClientAddresses', 'uses' => 'ClientAddressController@getClientAddresses']);
    Route::post('client/add/address', ['as' => 'addClientAddress', 'uses' => 'ClientAddressController@addClientAddress']);
    Route::post('client/delete/address', ['as' => 'deleteClientAddress', 'uses' => 'ClientAddressController@deleteClientAddress']);

    // Client company
    Route::post('client/list/companies', ['as' => 'getClientCompanies', 'uses' => 'ClientCompanyController@getClientCompanies']);
    Route::post('client/add/company', ['as' => 'addClientCompany', 'uses' => 'ClientCompanyController@addClientCompany']);
    Route::post('client/delete/company', ['as' => 'deleteClientCompany', 'uses' => 'ClientCompanyController@deleteClientCompany']);

    // Notification templates
    Route::post('notification-templates/list-model-variables', ['as' => 'listModelVars', 'uses' => 'NotificationTemplateCrudController@listModelVars']);
});
