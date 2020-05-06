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
    Route::crud('attributes', 'AttributeCrudController');
    Route::crud('attributes-sets', 'AttributeSetCrudController');
    Route::crud('products', 'ProductCrudController');
    Route::crud('taxes', 'TaxCrudController');
    Route::crud('orders', 'OrderCrudController');
    Route::crud('order-statuses', 'OrderStatusCrudController');
    Route::crud('cart-rules', 'CartRuleCrudController');
    Route::crud('notification-templates', 'NotificationTemplateCrudController');
    Route::crud('clients', 'ClientCrudController');
    Route::crud('users', 'UserCrudController');

    // Clone Products
    Route::post('products/clone', 'ProductCrudController@cloneProduct')->name('clone.product');

    // Update Order Status
    Route::post('orders/update-status', 'OrderCrudController@updateStatus')->name('updateOrderStatus');
    Route::get('orders/invoice/{id}', 'InvoiceController@generate')->name('generateInvoice');
}); // this should be the absolute last line of this file

// Ajax
Route::group([
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'prefix' => 'ajax',
    'namespace'  => 'App\Http\Controllers\Admin',
], function() {
    // Get attributes by set id
    Route::post('attribute-sets/list-attributes', 'AttributeSetCrudController@ajaxGetAttributesBySetId')->name('getAttrBySetId');

    // Product images upload routes
    Route::post('products/image/upload', 'ProductCrudController@ajaxUploadProductImages')->name('uploadProductImages');
    Route::post('products/image/reorder', 'ProductCrudController@ajaxReorderProductImages')->name('reorderProductImages');
    Route::post('products/image/delete', 'ProductCrudController@ajaxDeleteProductImage')->name('deleteProductImage');

    // Get group products by group id
    Route::post('product-group/list/products', 'ProductGroupController@getGroupProducts')->name('getGroupProducts');
    Route::post('product-group/list/ungrouped-products', 'ProductGroupController@getUngroupedProducts')->name('getUngroupedProducts');
    Route::post('product-group/add/product', 'ProductGroupController@addProductToGroup')->name('addProductToGroup');
    Route::post('product-group/remove/product', 'ProductGroupController@removeProductFromGroup')->name('removeProductFromGroup');

    // Client address
    Route::post('clients/list/addresses', 'ClientAddressController@getClientAddresses')->name('getClientAddresses');
    Route::post('clients/add/address', 'ClientAddressController@addClientAddress')->name('addClientAddress');
    Route::post('clients/delete/address', 'ClientAddressController@deleteClientAddress')->name('deleteClientAddress');

    // Client company
    Route::post('clients/list/companies', 'ClientCompanyController@getClientCompanies')->name('getClientCompanies');
    Route::post('clients/add/company', 'ClientCompanyController@addClientCompany')->name('addClientCompany');
    Route::post('clients/delete/company', 'ClientCompanyController@deleteClientCompany')->name('deleteClientCompany');

    // Notification templates
    Route::post('notification-templates/list-model-variables', 'NotificationTemplateCrudController@listModelVars')->name('listModelVars');
});
