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

Route::get('/{resource}/{id}', function (Request $request) {
    $resourceClass = 'App\\' . studly_case($request->resource);
    $resourceClass = rtrim($resourceClass, 's');

    /** @var Laravel\Scout\Searchable $resource */
    $resource = $resourceClass::find($request->id);

    $algoliaData = new AlgoliaData();
    $algoliaData->index = $resource->searchableAs();
    $algoliaData->data = $resource->toSearchableArray();

    return json_encode($algoliaData);
});

Route::get('/indexes', function () {
    $algoliaClient = new AlgoliaSearch\Client(config('scout.algolia.id'), config('scout.algolia.secret'));
    return $algoliaClient->listIndexes();
});

Route::post('/indexes/{name}/import', function (Request $request) {
    $class = 'App\\' . studly_case($request->name);
    $class = rtrim($class, 's');

    $model = new $class;

    $model::makeAllSearchable();

    return $model::count();
});

Route::post('/indexes/{name}/flush', function (Request $request) {
    $algoliaClient = new AlgoliaSearch\Client(config('scout.algolia.id'), config('scout.algolia.secret'));
    $index = $algoliaClient->initIndex($request->name);
    return $index->clearIndex();
});
