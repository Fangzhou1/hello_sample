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

      if($file==null){
        session()->flash('danger', '上传失败！上传文件不能为空，请重新上传');
        return 'error1';
      }
      else {
          $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, $this->allowed_ext)) {
                session()->flash('danger', '上传失败！上传文件不是excel，请重新上传');
                return 'error2';
            }
            set_time_limit(0);
            Excel::selectSheets('Sheet1')->load($file->path(), function($reader) {


              $this->results=$reader->get()->toArray();
      });
          return $this->results;
        }

    }


    public function download($export,$name)
    {
      Excel::create($name, function($excel) use ($export) {
        $excel->sheet('sheet1', function($sheet) use ($export){
          $sheet->fromArray($export);
        });
      })->export('xls');
    }

    public function exporttoserver($export,$name)
    {
      Excel::create($name, function($excel) use ($export) {
        $excel->sheet('sheet1', function($sheet) use ($export){
          $sheet->fromArray($export);
        });
      })->store('xls');
    }

}
