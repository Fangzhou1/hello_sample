<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
  protected $guarded = [];

  protected $hidden = [
      'created_at', 'updated_at'
  ];

  public function refunddetails()
    {
        return $this->hasMany('App\Models\Refunddetail','kkk2','kkk');
    }

}
