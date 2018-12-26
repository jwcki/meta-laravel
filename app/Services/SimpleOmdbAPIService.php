<?php

namespace App\Services;

use App\Services\Interfaces\OmdbAPIService;

class SimpleOmdbAPIService implements OmdbAPIService {
  public function __construct($host, $apiKey) {
    $this->host = $host;
    $this->apiKey = $apiKey;
  }

  public function search($searchStr) {
    $queryStr = http_build_query([
      's' => $searchStr,
      'apikey' => $this->apiKey,
    ]);
    $url = "http://{$this->host}/?{$queryStr}";
    return json_decode(file_get_contents($url), true);
  }
}