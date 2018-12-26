<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\OmdbAPIService;
use App\Services\Interfaces\EntryService;
use App\Http\Resources\EntryCollection;

class EntryController extends Controller
{
    public function __construct(OmdbAPIService $apiService, EntryService $entryService) {
        $this->apiService = $apiService;
        $this->entryService = $entryService;
    }

    public function __invoke(Request $request) {
        $searchStr = $request->query('s');
        $response = $this->apiService->search($searchStr);

        $entries = [];

        if (isset($response['Search'])) {
            foreach ($response['Search'] as $rawData) {
                $entryData = collect($rawData)->flatMap(function($value, $key) {
                    return [lcfirst($key) => $value];
                });
                $entries[] = $this->entryService->update($entryData);
            }
        }

        return new EntryCollection(collect($entries));
    }
}
