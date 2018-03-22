<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Settlement extends Model
{
    use Searchable;
    protected $guarded = [];

    public function searchableAs()
    {
        return 'settlements_index';
    }

    public function toSearchableArray()
   {
     $array = $this->toArray();
     return $array;
   }
}
