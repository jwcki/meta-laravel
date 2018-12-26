<?php

namespace App\Services\Interfaces;

interface OmdbAPIService {
  public function search($searchStr);
}