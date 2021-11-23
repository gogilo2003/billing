<?php

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\DomainController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductCategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('accounts', ['as' => 'api-accounts', 'uses' => 'Api\AccountController@getAccounts']);
    Route::post('accounts/months', ['as' => 'api-accounts-months', 'uses' => 'Api\AccountController@getMonths']);

    Route::get('categories', function () {
        $categories = ProductCategory::orderBy('name', 'ASC')->get()->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
            ];
        });
        $success = true;

        return response()->json(compact('success', 'categories'));
    });

    Route::group(['as' => 'api-accounts-', 'prefix' => 'accounts'], function () {
        Route::get('', [AccountController::class, 'index']);
        Route::group(['as' => 'notification-', 'prefix' => 'notification'], function () {
            Route::post('update', [AccountController::class, 'updateNotification'])->name('update');
            Route::get('show', [AccountController::class, 'showNotification'])->name('show');
        });
    });

    Route::group(['as' => 'api-clients-', 'prefix' => 'clients'], function () {
        Route::group(['as' => 'notification-', 'prefix' => 'notification'], function () {
            Route::post('update', [ClientController::class, 'updateNotification'])->name('update');
            Route::get('show', [ClientController::class, 'showNotification'])->name('show');
        });
        Route::get('', [ClientController::class, 'index'])->name('list');
        Route::get('accounts', [ClientController::class, 'accounts']);
    });

    Route::group(['as' => 'api-domains', 'prefix' => 'domains'], function () {
        Route::get('/{status?}', [DomainController::class, 'index']);
        Route::post('', [DomainController::class, 'store'])->name('-create');
        Route::patch('', [DomainController::class, 'update'])->name('-update');
        Route::delete('', [DomainController::class, 'destroy'])->name('-delete');
        Route::post('status', [DomainController::class, 'status'])->name('-status');
        Route::post('import', [DomainController::class, 'import'])->name('-import');
        Route::post('notify', [DomainController::class, 'notify'])->name('-notify');
        Route::post('renew', [DomainController::class, 'renew'])->name('-renew');
    });

    Route::group(['as' => 'api-products', 'prefix' => 'products'], function () {
        Route::get('/{id?}', [ProductController::class, 'index']);
        Route::post('', [ProductController::class, 'store'])->name('-create');
        Route::patch('', [ProductController::class, 'update'])->name('-update');
        Route::delete('', [ProductController::class, 'destroy'])->name('-delete');
        Route::post('import', [ProductController::class, 'import'])->name('-import');
    });

    Route::group(['as' => 'api-product-categories', 'prefix' => 'product-categories'], function () {
        Route::get('/{id?}', [ProductCategoryController::class, 'index']);
        Route::post('', [ProductCategoryController::class, 'store'])->name('-create');
        Route::patch('', [ProductCategoryController::class, 'update'])->name('-update');
        Route::delete('', [ProductCategoryController::class, 'destroy'])->name('-delete');
        Route::post('import', [ProductCategoryController::class, 'import'])->name('-import');
    });

    // Route::get('test', function () {
    //     // $client = Client::find(2);
    //     $d1 = now();
    //     $d2 = new Carbon('2021-08-04T02:20:48.144610Z');
    //     $diff = $d1->diffInSeconds($d2);

    //     return response()->json([compact('d1', 'd2'), 'data' => $diff]);
    // })->name('test');

    Route::prefix('invoices')->group(function () {
        Route::get('', [InvoiceController::class, 'index']);
        Route::get('/show/{id}', [InvoiceController::class, 'show']);
        Route::post('', [InvoiceController::class, 'store']);
        Route::patch('', [InvoiceController::class, 'update']);
        Route::delete('', [InvoiceController::class, 'destroy']);
    });
});
