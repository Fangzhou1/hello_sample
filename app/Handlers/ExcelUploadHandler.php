<?php

namespace App\Handlers;
use Excel;
use App\Models\Settlement;

class ExcelUploadHandler
{
  protected $allowed_ext = ["xlsx", "xls", "xlsm"];
  protected $results;
  public function save($file)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $this->allowed_ext)) {
            session()->flash('danger', '上传文件不是excel，请重新上传');
            return redirect()->back();
        }
        set_time_limit(0);
        Excel::selectSheets('Sheet1')->load($file->path(), function($reader) {


          $this->results=$reader->get()->toArray();



  });
      return $this->results;
    }

}
