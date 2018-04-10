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

        return view('refunddetails.edit',['refunddetail'=>$refunddetail]);
    }

    public function update(Refunddetail $refunddetail)
      {
          // $page=10;
          // $settlements = Settlement::paginate($page);
          dd($refunddetail);
          return view('refunddetails.edit',['refunddetail'=>$refunddetail]);
      }

}
