<?php

// home screen route
Route::get('/', 'ProductsController@index')->name('index');

Auth::routes();

// all products routes
Route::get('/listings','ProductsController@index')->name('listings');

// users profile link
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/orders', 'HomeController@myorders')->name('home.myorders');

// admin area routes
Route::get('/admin', 'AdminController@index')->name('admin.home');
Route::get('/admin/products/create','AdminController@createProduct')->name('admin.products.create');
Route::post('/admin/products/store','AdminController@storeProduct')->name('admin.products.store');
Route::get('/admin/orders/manage','AdminController@manageOrder')->name('admin.orders.manage');
Route::post('/admin/orders/complete','AdminController@completeOrder')->name('admin.orders.complete');

// cart routes
Route::post('/cart/add','ShoppingController@add_to_cart')->name('cart.add');
Route::get('/cart','ShoppingController@cart')->name('cart');
Route::get('/cart/delete/{id}', 'ShoppingController@cart_delete')->name('cart.delete');
Route::post('/cart','ShoppingController@cart_save')->name('cart.save');

// cart checkout
Route::get('/cart/checkout','ShoppingController@checkout')->name('cart.checkout');
// Route::get('/payment','ShoppingController@pay')->name('pay');
