<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $primaryKey = 'imdbID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['title', 'year', 'type'];

    public function image() {
        return $this->hasOne('App\EntryImage', 'imdbID', 'imdbID');
    }

}
