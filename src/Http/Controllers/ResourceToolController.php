<?php

namespace NathanHeffley\NovaAlgolia\Http\Controllers;

use AlgoliaSearch\Client;
use Illuminate\Http\Request;
use Laravel\Scout\Searchable;
use Illuminate\Routing\Controller;
use AlgoliaSearch\AlgoliaException;
use NathanHeffley\NovaAlgolia\AlgoliaData;

class ResourceToolController extends Controller
{
    public function show(Request $request) {
        /** @var Searchable $resource */
        $resource = $request->resourceClass::find($request->id);

        $algoliaData = new AlgoliaData();
        $algoliaData->index = $resource->searchableAs();

        $algoliaClient = new Client(config('scout.algolia.id'), config('scout.algolia.secret'));
        $index = $algoliaClient->initIndex($resource->searchableAs());

        try {
            $algoliaData->data = $index->getObject($resource->getScoutKey());
        } catch (AlgoliaException $e) {
            $algoliaData->data = null;
        }

        return json_encode($algoliaData);
    }

    public function import(Request $request) {
        /** @var Searchable $resource */
        $resource = $request->resourceClass::find($request->id);

        $resource->searchable();

        $algoliaData = new AlgoliaData();
        $algoliaData->index = $resource->searchableAs();
        $algoliaData->data = $resource->toSearchableArray();
        $algoliaData->data['objectID'] = $resource->getScoutKey();

        return json_encode($algoliaData);
    }

    public function flush(Request $request) {
        /** @var Searchable $resource */
        $resource = $request->resourceClass::find($request->id);

        $resource->unsearchable();

        $algoliaData = new AlgoliaData();
        $algoliaData->index = $resource->searchableAs();

        return json_encode($algoliaData);
    }
}
