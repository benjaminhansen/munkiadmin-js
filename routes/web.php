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
    Route::get('manifests/{content?}', 'Api\\GetController@manifests');
    Route::get('catalogs/{content?}', 'Api\\GetController@catalogs');
    Route::get('icons', 'Api\\GetController@icons');
    Route::get('packages', 'Api\\GetController@packages');
    Route::get('packages-info/{content?}', 'Api\\GetController@packagesInfo');
    Route::get('categories/{query?}', 'Api\\GetController@categories');
    Route::get('developers/{query?}', 'Api\\GetController@developers');
});

Route::get('/', function(){ return redirect('packages'); });
Route::get('catalogs', 'CatalogsController@index');
Route::get('packages', 'PackagesController@index');
Route::get('manifests', 'ManifestsController@index');
