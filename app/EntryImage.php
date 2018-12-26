<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntryImage extends Model
{
    protected $primaryKey = 'imdbID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['url'];

    public function entry() {
        return $this->belongsTo('App\Entry', 'imdbID', 'imdbID');
    }
    
}
