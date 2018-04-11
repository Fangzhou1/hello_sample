<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refunddetail extends Model
{
  protected $guarded = [];

  protected $hidden = [
      'created_at', 'updated_at'
  ];

  public function refunds()
    {
        return $this->belongsTo('App\Models\Refund','kkk2','kkk');
    }

  // public static function boot()
  //    {
  //        parent::boot();
  //
  //        static::creating(function ($refunddetail) {
  //          $kkk2=$refunddetail->project_number.'/'.$refunddetail->audit_document_number
  //            $refunddetail->kkk2 = $kkk2;
  //        });
  //    }
}
