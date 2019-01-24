<?php


Route::group(['middleware' => 'auth'], function () {
    Route::resource('quotes', 'QuoteController',['except' => ['index', 'show']]);
    Route::post('quote-comment/{id}', 'QuoteCommentController@store');
    Route::get('quote-comment/{id}/edit', 'QuoteCommentController@edit');
    Route::put('quote-comment/{id}', 'QuoteCommentController@update');
    Route::delete('quote-comment/{id}', 'QuoteCommentController@destroy');
});

Route::get('/', function () { return view('welcome'); });
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile/{id?}', 'HomeController@profile');
Route::get('quotes/random', 'QuoteController@random');
Route::get('quotes/filter/{tag}', 'QuoteController@filter');
Route::resource('quotes', 'QuoteController', ['only' => ['index', 'show']]);

