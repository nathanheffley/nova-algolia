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

Route::get('/{resourceClass}/{id}', function (Request $request) {
    /** @var Laravel\Scout\Searchable $resource */
    $resource = $request->resourceClass::find($request->id);

    $algoliaData = new AlgoliaData();
    $algoliaData->index = $resource->searchableAs();

    $algoliaClient = new AlgoliaSearch\Client(config('scout.algolia.id'), config('scout.algolia.secret'));
    $index = $algoliaClient->initIndex($resource->searchableAs());

    try {
        $algoliaData->data = $index->getObject($resource->getScoutKey());
    } catch (\AlgoliaSearch\AlgoliaException $e) {
        $algoliaData->data = null;
    }

    return json_encode($algoliaData);
});

Route::post('/{resourceClass}/{id}', function (Request $request) {
    /** @var Laravel\Scout\Searchable $resource */
    $resource = $request->resourceClass::find($request->id);

    $resource->searchable();

    $algoliaData = new AlgoliaData();
    $algoliaData->index = $resource->searchableAs();
    $algoliaData->data = $resource->toSearchableArray();
    $algoliaData->data['objectID'] = $resource->getScoutKey();

    return json_encode($algoliaData);
});

Route::delete('/{resourceClass}/{id}', function (Request $request) {
    /** @var Laravel\Scout\Searchable $resource */
    $resource = $request->resourceClass::find($request->id);

    $resource->unsearchable();

    $algoliaData = new AlgoliaData();
    $algoliaData->index = $resource->searchableAs();

    return json_encode($algoliaData);
});
