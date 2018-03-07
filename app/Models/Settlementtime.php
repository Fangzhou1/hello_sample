<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settlementtime extends Model
{
  protected $fillable = [
      'finished_ordernum','finished_projectnum'
  ];
}
