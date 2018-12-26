<?php

namespace App\Services\Interfaces;

use App\Entry;

interface EntryService {
  public function update($entryData): Entry;
}