<?php

Route::group(['middleware'=>'auth','namespace'=>'App\Http\Controllers'],function(){
	Route::get('/',['as'=>'welcome','uses'=>'HomeController@index']);
	Route::get('/profile',['as'=>'profile','uses'=>'HomeController@showProfile']);
	Route::post('/profile',['as'=>'profile','uses'=>'HomeController@postProfile']);
	Route::post('/picture',['as'=>'picture','uses'=>'HomeController@postPicture']);
	Route::post('/password',['as'=>'password','uses'=>'HomeController@postPassword']);

	Route::group(['as'=>'clients','prefix'=>'clients'],function(){
		Route::get('',['as'=>'','uses'=>'ClientController@index']);
		Route::get('create',['as'=>'-create','uses'=>'ClientController@getCreate']);
		Route::get('edit/{id}',['as'=>'-edit','uses'=>'ClientController@getEdit']);
		Route::get('view/{id}',['as'=>'-view','uses'=>'ClientController@getView']);
		Route::get('download/{id}',['as'=>'-download','uses'=>'ClientController@downloadClient']);
		Route::get('clients-download',['as'=>'-clients-download','uses'=>'ClientController@downloadClients']);
		Route::post('create',['as'=>'-create-post','uses'=>'ClientController@postCreate']);
		Route::post('update',['as'=>'-update','uses'=>'ClientController@postUpdate']);
		Route::post('delete',['as'=>'-delete','uses'=>'ClientController@postDelete']);

	});

	Route::group(['as'=>'accounts','prefix'=>'accounts'],function(){
		Route::get('list/{client_id?}',['as'=>'','uses'=>'AccountController@index']);
		Route::get('create/{client_id?}',['as'=>'-create','uses'=>'AccountController@getCreate']);
		Route::get('transaction/{account?}',['as'=>'-transaction','uses'=>'AccountController@getTransaction']);
		Route::get('edit/{id}',['as'=>'-edit','uses'=>'AccountController@getEdit']);
		Route::get('view/{id}',['as'=>'-view','uses'=>'AccountController@getView']);
		Route::get('download/{id}',['as'=>'-download','uses'=>'AccountController@downloadAccount']);
		Route::post('create',['as'=>'-create-post','uses'=>'AccountController@postCreate']);
		Route::post('update',['as'=>'-update','uses'=>'AccountController@postUpdate']);
        Route::post('transaction',['as'=>'-transaction-post','uses'=>'AccountController@postTransaction']);
        Route::group(['prefix'=>'transactions','as'=>'-transactions'],function(){
            Route::get('{account_id?}',['as'=>'','uses'=>'TransactionsController@getTransactions']);
            Route::get('download/{transaction_id}',['as'=>'-download','uses'=>'TransactionsController@downloadTransaction']);
            Route::post('update',['as'=>'-update','uses'=>'TransactionsController@postUpdate']);
        });
	});

	Route::group(['as'=>'invoices','prefix'=>'invoices'],function(){
		Route::get('list/{client_id?}',['as'=>'','uses'=>'InvoiceController@index']);
		Route::get('create/{client_id?}',['as'=>'-create','uses'=>'InvoiceController@getCreate']);
		Route::get('edit/{id}',['as'=>'-edit','uses'=>'InvoiceController@getEdit']);
		Route::get('view/{id}',['as'=>'-view','uses'=>'InvoiceController@getView']);
		Route::post('create',['as'=>'-create-post','uses'=>'InvoiceController@postCreate']);
		Route::post('merge',['as'=>'-merge-post','uses'=>'InvoiceController@postMerge']);
		Route::get('download/{id}',['as'=>'-download','uses'=>'InvoiceController@downloadInvoice']);
		Route::get('delivery/{id}',['as'=>'-delivery','uses'=>'InvoiceController@downloadDelivery']);
	});

	Route::group(['as'=>'product_categories','prefix'=>'product_categories'],function(){
		Route::post('create',['as'=>'-create','uses'=>'ProductCategoryController@postCreate']);
		Route::post('update',['as'=>'-update','uses'=>'ProductCategoryController@postUpdate']);
		Route::post('delete',['as'=>'-delete','uses'=>'ProductCategoryController@postDelete']);
	});

	Route::group(['as'=>'products','prefix'=>'products'],function(){
		Route::get('list/{category_id?}',['as'=>'','uses'=>'ProductController@index']);
		Route::get('edit/{id}',['as'=>'-edit','uses'=>'ProductController@getEdit']);
		Route::get('view/{id}',['as'=>'-view','uses'=>'ProductController@getView']);
		Route::get('download/{id}',['as'=>'-download','uses'=>'ProductController@downloadProduct']);
		Route::post('create',['as'=>'-create','uses'=>'ProductController@postCreate']);
		Route::post('update',['as'=>'-update','uses'=>'ProductController@postUpdate']);
		Route::post('delete',['as'=>'-delete','uses'=>'ProductController@postDelete']);
	});

	Route::group(['as'=>'services','prefix'=>'services'],function(){
		Route::get('list/{client_id?}',['as'=>'','uses'=>'ServiceController@index']);
		Route::get('view/{id}',['as'=>'-view','uses'=>'ServiceController@getView']);
		Route::post('update/{id}',['as'=>'-update','uses'=>'ServiceController@postUpdate']);
		Route::post('create',['as'=>'-create','uses'=>'ServiceController@postCreate']);
		Route::post('update',['as'=>'-update','uses'=>'ServiceController@postUpdate']);
    });

    Route::group(['prefix' => 'setup', 'as'=>'setup'], function () {
        Route::get('', ['as'=>'','uses'=>'SetupController@getSetup']);
        Route::post('migrate', ['as'=>'-migrate','uses'=>'SetupController@postMigrate']);
    });

});

Route::get('test',function(){
    $pdf = PDF::loadView('test');
    return $pdf->download('test.pdf');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::group(['middleware' => 'auth'], function () {
// 		Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);
// 		Route::get('maps', ['as' => 'pages.maps', 'uses' => 'App\Http\Controllers\PageController@maps']);
// 		Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'App\Http\Controllers\PageController@notifications']);
// 		Route::get('rtl', ['as' => 'pages.rtl', 'uses' => 'App\Http\Controllers\PageController@rtl']);
// 		Route::get('tables', ['as' => 'pages.tables', 'uses' => 'App\Http\Controllers\PageController@tables']);
// 		Route::get('typography', ['as' => 'pages.typography', 'uses' => 'App\Http\Controllers\PageController@typography']);
// 		Route::get('upgrade', ['as' => 'pages.upgrade', 'uses' => 'App\Http\Controllers\PageController@upgrade']);
// });

Route::group(['middleware' => 'auth'], function () {
	// Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Route::get('sms',[App\Http\Controllers\HomeController::class,'sendSms']);

Route::group(['middleware'=>'auth','as'=>'messages','prefix'=>'messages','namespace'=>'App\Http\Controllers'],function(){
    Route::get('',['uses'=>'MessagesController@index']);
    Route::get('create',['as'=>'-create','uses'=>'MessagesController@create']);
    Route::post('store',['as'=>'-store','uses'=>'MessagesController@store']);
});
