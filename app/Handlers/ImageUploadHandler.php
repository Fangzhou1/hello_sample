<?php

namespace App\Handlers;
use Image;

class ImageUploadHandler
{
  protected $allowed_ext = ["png", "jpg", "gif", 'jpeg'];

  public function save($file, $filefolder,$max_width = false)
    {
      $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
      if (!in_array($extension, $this->allowed_ext)) {
          session()->flash('danger', '上传文件不是图片，请重新上传');
          return redirect()->back();
      }
      $filename=time().'_'.str_random(10).'.'.$extension;
      $sql_filefolder_name='/Uplouds/images/'.$filefolder.'/'.date("Ym", time()).'/'.date("d", time()).'/';
      $file->move(public_path().$sql_filefolder_name,$filename);
      if ($max_width && $extension != 'gif') {
          // 此类中封装的函数，用于裁剪图片
            $this->reduceSize(public_path().$sql_filefolder_name.$filename, $max_width);
        }

      return [
            'path' =>$sql_filefolder_name.$filename
        ];
    }

    public function reduceSize($file_path, $max_width)
    {
        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($file_path);

        // 进行大小调整的操作
        $image->resize($max_width, null, function ($constraint) {

            // 设定宽度是 $max_width，高度等比例双方缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        // 对图片修改后进行保存
        $image->save();
    }
}
