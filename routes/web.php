<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'api/v1'], function(){
    Route::get('manifests', 'Api\\GetController@manifests');
    Route::get('catalogs', 'Api\\GetController@catalogs');
    Route::get('icons', 'Api\\GetController@icons');
    Route::get('packages', 'Api\\GetController@packages');
    Route::get('packages-info', 'Api\\GetController@packagesInfo');
    Route::get('categories', 'Api\\GetController@categories');
    Route::get('developers', 'Api\\GetController@developers');
});

Route::get('catalogs', 'CatalogsController@index');
Route::get('packages', 'PackagesController@index');
Route::get('manifests', 'ManifestsController@index');
