<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refunddetail extends Model
{
  protected $guarded = [];

  protected $hidden = [
      'created_at', 'updated_at'
  ];
}
