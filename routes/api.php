<?php

use Illuminate\Http\Request;

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

// TODO: Check this route! Do we need it? I don't think we do. DUBBLE CHECK!
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

/**
* Login/register routes
*/
Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/register', 'Auth\RegisterController@register');
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'auth'], function () {
    // Authentication Routes...
    Route::get('/logout', 'Auth\LoginController@logout');
    Route::get('/user', 'UserController@getUser');
});

/*
* Api endpoints consumed by the client application written in Angular 2.
*/
Route::group(['prefix' => 'application'], function () {

    /*
    * Api endpoints for all the child data.
    */
    Route::group(['prefix' => 'children'], function () {
        Route::get('/', 'ChildController@index');
        Route::get('/{childShortId}', 'ChildController@getChild');
        Route::get('/{childShortId}/quotes', 'ChildController@allQuotes');
        Route::post('/new', 'ChildController@new');
        Route::post('/{childShortId}/upload', 'ChildController@uploadImage');
        Route::delete('/{childShortId}/delete', 'ChildController@delete');
        Route::put('/{childShortId}/edit', 'ChildController@update');

        /*
        * Api endpoints for quotes
        */
        Route::post('/{childShortId}/quotes/new', 'QuoteController@new');
        Route::delete('{childShortId}/quotes/{quoteShortId}/delete', 'QuoteController@delete');

    });

    /*
    * Api endpoints for book data.
    */
    Route::group(['prefix' => 'books'], function () {
        Route::post('/new', 'BookController@new');
        // Route::put('');
        Route::get('/{shortId}', 'BookController@getBook');
        Route::get('/all', 'BookController@index');
        Route::delete('/{shortId}/delete', 'BookController@delete');
    });
});
