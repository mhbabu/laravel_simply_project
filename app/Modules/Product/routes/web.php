<?php

Route::group(['prefix'=>'admin','module' => 'Product', 'middleware' => ['web','auth'], 'namespace' => 'App\Modules\Product\Controllers'], function() {

    /*
     * Product Category Routes
     */
    Route::resource('product/categories', 'CategoryController', ['names' => [
        'index'     => 'admin.product.categories.index',
        'create'    => 'admin.product.categories.create',
        'store'     => 'admin.product.categories.store',
        'edit'      => 'admin.product.categories.edit',
        'update'    => 'admin.product.categories.update',
        'destroy'   => 'admin.product.categories.destroy'
    ]]);

    /*
     *  Product Subcategory Routes
     */
    Route::get('product/subcategories-by-category','SubcategoryController@subcategoriesByCategory');

    Route::resource('product/subcategories', 'SubcategoryController', ['names' => [
        'index'    => 'admin.product.subcategories.index',
        'create'   => 'admin.product.subcategories.create',
        'store'    => 'admin.product.subcategories.store',
        'edit'     => 'admin.product.subcategories.edit',
        'update'   => 'admin.product.subcategories.update',
        'destroy'  => 'admin.product.subcategories.destroy'
    ]]);

    /*
     * Product Routes
     */

    Route::resource('products', 'ProductController', ['names' => [
        'index'     => 'admin.products.index',
        'create'    => 'admin.products.create',
        'store'     => 'admin.products.store',
        'edit'      => 'admin.products.edit',
        'update'    => 'admin.products.update',
        'show'      => 'admin.products.show',
        'destroy'   => 'admin.products.destroy'
    ]]);

});
