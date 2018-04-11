<?php

namespace App\Http\Controllers;
use App\Models\Refunddetail;
use App\Models\Refund;
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

      public function store()
        {
          //dd(route('refunds.refundsdetail',['refunddetails'=>$refund->refunddetails]));
          $query=$this->request->post('project_number').'/'.$this->request->post('audit_document_number');
          $refund=Refund::where('kkk',$query)->first();
          //dd($refund);
        //  dd(route('refunds.refundsdetail',['refund'=>$refund]));
          $refund->refunddetails()->create($this->request->post());
          session()->flash('success', '恭喜你，新增数据成功！');

          return redirect()->route('refunds.refundsdetail',['refund'=>$refund]);

        }

        public function destroy(Refunddetail $refunddetail)
        {
          //dd($refunddetail);
          $refunddetailadn=$refunddetail->audit_document_number;
          $refunddetailpn=$refunddetail->project_number;
          $refunddetail->delete();
          // $data['name']=Auth::user()->name;
          // $data['audit_document_number']=$refunddetailadn;
          // $data['project_number']=$refunddetailpn;
          // $data['type']='物资详情';
          // $mes='删除了';
          //$mes2=event(new ModifyDates($data,$mes));
          //broadcast(new ChangeOrder(Auth::user(),$Settlementodn,"刚刚删除了订单编号为",$mes2));
          session()->flash('success', '恭喜你，删除成功！');
          return redirect()->back();

        }


}
