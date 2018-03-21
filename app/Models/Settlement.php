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
        return 'settlements';
    }

    public function toSearchableArray()
   {
       return ['order_number'=>$this->order_number,
               'vendor_name'=>$this->vendor_name,
               'material_name'=>$this->material_name,
               'material_type'=>$this->material_type,
               'project_number'=>$this->project_number,
               'project_name'=>$this->project_name,
               'project_manager'=>$this->project_manager,
               'audit_progress'=>$this->audit_progress,
               'audit_document_number'=>$this->audit_document_number,
               'audit_company'=>$this->audit_company,
               'contract_number'=>$this->contract_number,
               'order_description'=>$this->order_description,
               'audit_number'=>$this->audit_number,
               'cost'=>$this->cost,
               'paid_cost'=>$this->paid_cost,
               'mis_cost'=>$this->mis_cost,
               'submit_cost'=>$this->submit_cost,
               'validation_cost'=>$this->validation_cost,
];
   }
}
