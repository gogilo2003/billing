<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth', 'namespace' => 'App\Http\Controllers'], function () {
    Route::get('/', ['as' => 'welcome', 'uses' => 'HomeController@index']);
    Route::get('/profile', ['as' => 'profile', 'uses' => 'HomeController@showProfile']);
    Route::post('/profile', ['as' => 'profile', 'uses' => 'HomeController@postProfile']);
    Route::post('/picture', ['as' => 'picture', 'uses' => 'HomeController@postPicture']);
    Route::post('/password', ['as' => 'password', 'uses' => 'HomeController@postPassword']);

    Route::group(['as' => 'clients', 'prefix' => 'clients'], function () {
        Route::get('', ['as' => '', 'uses' => 'ClientController@index']);
        Route::get('create', ['as' => '-create', 'uses' => 'ClientController@getCreate']);
        Route::get('edit/{id}', ['as' => '-edit', 'uses' => 'ClientController@getEdit']);
        Route::get('view/{id}', ['as' => '-view', 'uses' => 'ClientController@getView']);
        Route::get('download/{id}', ['as' => '-download', 'uses' => 'ClientController@downloadClient']);
        Route::get('clients-download', ['as' => '-clients-download', 'uses' => 'ClientController@downloadClients']);
        Route::post('create', ['as' => '-create-post', 'uses' => 'ClientController@postCreate']);
        Route::post('update', ['as' => '-update', 'uses' => 'ClientController@postUpdate']);
        Route::post('delete', ['as' => '-delete', 'uses' => 'ClientController@postDelete']);
    });

    Route::group(['as' => 'accounts', 'prefix' => 'accounts'], function () {
        Route::get('list/{client_id?}', ['as' => '', 'uses' => 'AccountController@index']);
        Route::get('create/{client_id?}', ['as' => '-create', 'uses' => 'AccountController@getCreate']);
        Route::get('transaction/{account?}', ['as' => '-transaction', 'uses' => 'AccountController@getTransaction']);
        Route::get('edit/{id}', ['as' => '-edit', 'uses' => 'AccountController@getEdit']);
        Route::get('view/{id}', ['as' => '-view', 'uses' => 'AccountController@getView']);
        Route::get('download/{id}', ['as' => '-download', 'uses' => 'AccountController@downloadAccount']);
        Route::post('create', ['as' => '-create-post', 'uses' => 'AccountController@postCreate']);
        Route::post('update', ['as' => '-update', 'uses' => 'AccountController@postUpdate']);
        Route::post('transaction', ['as' => '-transaction-post', 'uses' => 'AccountController@postTransaction']);
        Route::group(['prefix' => 'transactions', 'as' => '-transactions'], function () {
            Route::get('{account_id?}', ['as' => '', 'uses' => 'TransactionsController@getTransactions']);
            Route::get('download/{transaction_id}', ['as' => '-download', 'uses' => 'TransactionsController@downloadTransaction']);
            Route::post('update', ['as' => '-update', 'uses' => 'TransactionsController@postUpdate']);
        });
    });

    Route::group(['as' => 'invoices', 'prefix' => 'invoices'], function () {
        Route::get('', ['as' => '', 'uses' => 'InvoiceController@index']);
        Route::get('create/{client_id?}', ['as' => '-create', 'uses' => 'InvoiceController@getCreate']);
        Route::get('edit/{id}', ['as' => '-edit', 'uses' => 'InvoiceController@getEdit']);
        Route::get('view/{id}', ['as' => '-view', 'uses' => 'InvoiceController@getView']);
        Route::post('create', ['as' => '-create-post', 'uses' => 'InvoiceController@postCreate']);
        Route::post('merge', ['as' => '-merge-post', 'uses' => 'InvoiceController@postMerge']);
        Route::get('download/{id}', ['as' => '-download', 'uses' => 'InvoiceController@downloadInvoice']);
        Route::get('delivery/{id}', ['as' => '-delivery', 'uses' => 'InvoiceController@downloadDelivery']);
    });

    Route::group(['as' => 'product_categories', 'prefix' => 'product_categories'], function () {
        Route::post('create', ['as' => '-create', 'uses' => 'ProductCategoryController@postCreate']);
        Route::post('update', ['as' => '-update', 'uses' => 'ProductCategoryController@postUpdate']);
        Route::post('delete', ['as' => '-delete', 'uses' => 'ProductCategoryController@postDelete']);
    });

    Route::group(['as' => 'products', 'prefix' => 'products'], function () {
        Route::get('list/{category_id?}', ['as' => '', 'uses' => 'ProductController@index']);
        Route::get('edit/{id}', ['as' => '-edit', 'uses' => 'ProductController@getEdit']);
        Route::get('view/{id}', ['as' => '-view', 'uses' => 'ProductController@getView']);
        Route::get('download/{id}', ['as' => '-download', 'uses' => 'ProductController@downloadProduct']);
        Route::post('create', ['as' => '-create', 'uses' => 'ProductController@postCreate']);
        Route::post('update', ['as' => '-update', 'uses' => 'ProductController@postUpdate']);
        Route::post('delete', ['as' => '-delete', 'uses' => 'ProductController@postDelete']);
    });

    Route::group(['as' => 'services', 'prefix' => 'services'], function () {
        Route::get('list/{client_id?}', ['as' => '', 'uses' => 'ServiceController@index']);
        Route::get('view/{id}', ['as' => '-view', 'uses' => 'ServiceController@getView']);
        Route::post('update/{id}', ['as' => '-update', 'uses' => 'ServiceController@postUpdate']);
        Route::post('create', ['as' => '-create', 'uses' => 'ServiceController@postCreate']);
        Route::post('update', ['as' => '-update', 'uses' => 'ServiceController@postUpdate']);
    });

    Route::group(['prefix' => 'setup', 'as' => 'setup'], function () {
        Route::get('', ['as' => '', 'uses' => 'SetupController@getSetup']);
        Route::post('migrate', ['as' => '-migrate', 'uses' => 'SetupController@postMigrate']);
    });

    Route::get('/products', function () {
        return view('products.index');
    })->name('products');

    Route::get('/domains', function () {
        return view('domains.index');
    })->name('domains');

    Route::get('/quotations', function () {
        return view('quotations.index');
    })->name('quotations');
});

Route::get('test', function () {
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

Route::get('sms', [App\Http\Controllers\HomeController::class, 'sendSms']);

Route::group(['middleware' => 'auth', 'as' => 'messages', 'prefix' => 'messages', 'namespace' => 'App\Http\Controllers'], function () {
    Route::get('', ['uses' => 'MessagesController@index']);
    Route::get('create', ['as' => '-create', 'uses' => 'MessagesController@create']);
    Route::post('store', ['as' => '-store', 'uses' => 'MessagesController@store']);
});

Route::get('icons', function () {
    $icons = collect(['icon-alert-circle-exc', 'icon-align-center', 'icon-align-left-2', 'icon-app', 'icon-atom', 'icon-attach-87', 'icon-badge', 'icon-bag-16', 'icon-bank', 'icon-basket-simple', 'icon-bell-55', 'icon-bold', 'icon-book-bookmark', 'icon-bulb-63', 'icon-bullet-list-67', 'icon-bus-front-12', 'icon-button-pause', 'icon-button-power', 'icon-calendar-60', 'icon-camera-18', 'icon-caps-small', 'icon-cart', 'icon-chart-bar-32', 'icon-chart-pie-36', 'icon-chat-33', 'icon-check-2', 'icon-cloud-download-93', 'icon-cloud-upload-94', 'icon-coins', 'icon-compass-05', 'icon-controller', 'icon-credit-card', 'icon-delivery-fast', 'icon-double-left', 'icon-double-right', 'icon-email-85', 'icon-gift-2', 'icon-globe-2', 'icon-headphones', 'icon-heart-2', 'icon-html5', 'icon-image-02', 'icon-istanbul', 'icon-key-25', 'icon-laptop', 'icon-light-3', 'icon-link-72', 'icon-lock-circle', 'icon-map-big', 'icon-minimal-down', 'icon-minimal-left', 'icon-minimal-right', 'icon-minimal-up', 'icon-mobile', 'icon-molecule-40', 'icon-money-coins', 'icon-notes', 'icon-palette', 'icon-paper', 'icon-pencil', 'icon-pin', 'icon-planet', 'icon-puzzle-10', 'icon-satisfied', 'icon-scissors', 'icon-send', 'icon-settings-gear-63', 'icon-settings', 'icon-simple-add', 'icon-simple-delete', 'icon-simple-remove', 'icon-single-02', 'icon-single-copy-04', 'icon-sound-wave', 'icon-spaceship', 'icon-square-pin', 'icon-support-17', 'icon-tablet-2', 'icon-tag', 'icon-tap-02', 'icon-tie-bow', 'icon-time-alarm', 'icon-trash-simple', 'icon-triangle-right-17', 'icon-trophy', 'icon-tv-2', 'icon-upload', 'icon-user-run', 'icon-vector', 'icon-video-66', 'icon-volume-98', 'icon-wallet-43', 'icon-watch-time', 'icon-wifi', 'icon-world', 'icon-zoom-split', 'icon-refresh-01', 'icon-refresh-02', 'icon-shape-star', 'icon-components']);
    return view('icons', compact('icons'));
});
