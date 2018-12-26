<?php

namespace App\Services;

use App\Services\Interfaces\EntryService;

use App\Entry;
use App\EntryImage;

class EloquentEntryService implements EntryService {
  public function update($entryData): Entry {
    $entryObj = Entry::with('image')->find($entryData['imdbID']);
    if (is_null($entryObj)) {
      $entryObj = new Entry;
      $entryObj->imdbID = $entryData['imdbID'];
    }

    if ($this->needUpdate($entryObj, $entryData)) {
      $entryObj->title = $entryData['title'];
      $entryObj->year = $entryData['year'];
      $entryObj->type = $entryData['type'];
      $entryObj->save();
    }

    if ($this->needUpdateImage($entryObj, $entryData)) {
      $imageObj = new EntryImage;
      $imageObj->url = $entryData['poster'];
      $entryObj->image()->save($imageObj);
      $entryObj->load('image');
    } else if ($this->needDeleteImage($entryObj, $entryData)) {
      $entryObj->image()->delete();
      $entryObj->load('image');
    }

    return $entryObj;
  }

  private function needUpdate($entryObj, $entryData): bool {
    return $entryObj->title !== $entryData['title']
      || $entryObj->year !== $entryData['year']
      || $entryObj->type !== $entryData['type']
    ;
  }

  private function needUpdateImage($entryObj, $entryData): bool {
    return $this->isStartWithHttp($entryData['poster'])
        && (
          is_null($entryObj->image) 
          || $entryObj->image->url !== $entryData['poster']
        )
      ;
  }

  private function needDeleteImage($entryObj, $entryData): bool {
    return !$this->isStartWithHttp($entryData['poster'])
      && !is_null($entryObj->image)
    ;
  }

  private function isStartWithHttp($str) {
    return strpos($str, 'http') === 0;
  }

}