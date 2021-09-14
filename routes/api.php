<?php

use App\Models\Client;
use App\Models\Account;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\DomainController;
use App\Http\Controllers\Api\AccountController;

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

    Route::get('products', function () {
        $products = Product::with('product_category')->orderBy('products.name', 'ASC')->get();
        $data = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'category' => $product->product_category ? $product->product_category->name : null,
                'name' => $product->name,
                'price' => $product->price,
            ];
        });
        $success = true;

        return response()->json(compact('data'));
    });

    Route::group(['as' => 'api-accounts-', 'prefix' => 'accounts'], function () {
        Route::group(['as' => 'notification-', 'prefix' => 'notification'], function () {
            Route::post('update', [AccountController::class, "updateNotification"])->name('update');
            Route::get('show', [AccountController::class, "showNotification"])->name('show');
        });
    });

    Route::group(['as' => 'api-clients-', 'prefix' => 'clients'], function () {
        Route::group(['as' => 'notification-', 'prefix' => 'notification'], function () {
            Route::post('update', [ClientController::class, "updateNotification"])->name('update');
            Route::get('show', [ClientController::class, "showNotification"])->name('show');
        });
    });

    Route::group(['as' => 'api-domains', 'prefix' => 'domains'], function () {
        Route::get('', [DomainController::class, "index"]);
        Route::post('', [DomainController::class, "store"])->name('-create');
        Route::patch('', [DomainController::class, "update"])->name('-update');
        Route::delete('', [DomainController::class, "destroy"])->name('-delete');
    });

    Route::get('test', function () {
        // $client = Client::find(2);
        $d1 = now();
        $d2 = new Carbon('2021-08-04T02:20:48.144610Z');
        $diff = $d1->diffInSeconds($d2);
        return response()->json([compact('d1', 'd2'), "data" => $diff]);
    })->name('test');
});
