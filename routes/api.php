<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use NathanHeffley\NovaAlgolia\AlgoliaData;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. You're free to add
| as many additional routes to this file as your tool may require.
|
*/

Route::get('/{resourceClass}/{id}', 'NathanHeffley\NovaAlgolia\Http\Controllers\ResourceToolController@show');
Route::post('/{resourceClass}/{id}', 'NathanHeffley\NovaAlgolia\Http\Controllers\ResourceToolController@import');
Route::delete('/{resourceClass}/{id}', 'NathanHeffley\NovaAlgolia\Http\Controllers\ResourceToolController@flush');
