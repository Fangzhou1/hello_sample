<?php

namespace App\Http\Controllers;
use App\Models\Refunddetail;
use Illuminate\Http\Request;

class RefunddetailsController extends Controller
{
  protected $request;
  public function __construct(Request $request)
  {
      $this->middleware('auth');
      //$this->middleware('check');
      $this->request=$request;
  }

  public function edit(Refunddetail $refunddetail)
    {
        // $page=10;
        // $settlements = Settlement::paginate($page);
      //dd($refunddetail);
        return view('refunddetails.edit',['refunddetail'=>$refunddetail,'unit_price'=>$this->request->input('unit_price')]);
    }

    public function update(Refunddetail $refunddetail)
      {
          // $page=10;
          // $settlements = Settlement::paginate($page);
          $data=$this->request->except(['_token','_method']);
          $refunddetail->update($data);
          session()->flash('success', '恭喜你，更新数据成功！');
          return redirect()->back();
      }

      public function create()
        {
          return view('refunddetails.create');
        }

}
