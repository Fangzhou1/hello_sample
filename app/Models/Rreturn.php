<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Rreturn extends Model
{
    use Searchable;
    protected $guarded = [];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function searchableAs()
    {
        return 'rreturns_index';
    }

    public function toSearchableArray()
   {
     $array = $this->toArray();
     return $array;
   }
}
