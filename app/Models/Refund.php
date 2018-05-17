<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Refund extends Model
{
  use Searchable;
  protected $guarded = [];

  protected $hidden = [
      'created_at', 'updated_at'
  ];

  public function refunddetails()
    {

        return $this->hasMany('App\Models\Refunddetail','kkk2','kkk');
    }

    public static function boot()
       {
           parent::boot();

           static::creating(function ($refund) {

             $kkk=$refund->project_number.'/'.$refund->audit_document_number;
               $refund->kkk = $kkk;
               $refund->project_number=strtoupper( $refund->project_number);

           });

           static::updating(function ($refund) {

               $refund->project_number=strtoupper( $refund->project_number);

           });
       }

     public function searchableAs()
     {
         return 'refunds_index';
     }

     public function toSearchableArray()
    {
      $array = $this->toArray();
      return $array;
    }

}
