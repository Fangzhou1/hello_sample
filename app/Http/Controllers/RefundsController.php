<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Refund;
use Illuminate\Support\Facades\DB;
use App\Models\Refunddetail;
use App\Handlers\ExcelUploadHandler;

class RefundsController extends Controller
{
  protected $request;
  public function __construct(Request $request)
  {
      $this->middleware('auth');
      //$this->middleware('check');
      $this->request=$request;
  }

  public function index()
    {
      //dd(parse_url('postgres://qkhdklcjrqaipc:df01a2f558215a0a7829c6aec0d4fc22e90a5def129294f53e08e42a3a97c911@ec2-54-235-66-81.compute-1.amazonaws.com:5432/d34bjielr59n77'));
        $page=10;
        $refunds['title'] = Refund::first();
        // $query=$this->request->input('query');
        // //dd($query);
        // if($query)
        //   $refunds['data'] = Refund::search($query)->paginate($page);
        // else
          $refunds['data'] = Refund::where('audit_report_name','<>','审计报告名称')->paginate($page);

        //$tracesdata=Trace::where('type','结算')->orderBy('created_at','desc')->get();
        // if($tracesdata->isEmpty()){
        //   return view('settlements.index',['current_url'=>$this->request->url(),'settlements'=>$refunds,'traces'=>[]]);
        // }
        // //dd($traces);
        // //dd($refunds);
        // foreach ($tracesdata as $value) {
        //   $traces[$value->year.'年'.$value->month.'月'][]=$value;
        // }

        //dd($traces);
        return view('refunds.index',['current_url'=>$this->request->url(),'refunds'=>$refunds]);
    }


  public function importpage()
    {
        // $page=10;
        // $settlements = Settlement::paginate($page);

        return view('refunds.importpage',['current_url'=>$this->request->url()]);
    }

    public function importrefunds()
      {
          Refund::truncate();
          //dd('已经清空');
          $file=$this->request->file('excel_r');
          $upload=new ExcelUploadHandler;
          $data=$upload->save($file);
          //dd($data);
          DB::table('refunds')->insert($data);
          session()->flash('success', '恭喜你，导入数据成功！');

          return redirect()->back();
      }

      public function importrefunddetails()
        {
            Refund::truncate();
            //dd('已经清空');
            $file=$this->request->file('excel_d');
            $upload=new ExcelUploadHandler;
            $data=$upload->save($file);
            //dd($data);
            DB::table('refunddetails')->insert($data);
            session()->flash('success', '恭喜你，导入数据成功！');

            return redirect()->back();
        }

        public function create()
        {
            return view('refunds.create');
        }

        public function store()
          {
          $datarequest=$this->request->except('_token');
          $refund=Refund::create($datarequest);
          // $data['name']=Auth::user()->name;
          // $data['order_number']=$refund->order_number;
          // $data['project_number']=$refund->project_number;
          // $data['type']='结算';
          // $mes='新建了';
          // $mes2=event(new ModifyDates($data,$mes));
          session()->flash('success', '恭喜你，添加数据成功！');
          //broadcast(new ChangeOrder(Auth::user(),$refund->order_number,"刚刚新增了订单编号为",$mes2));
          return redirect()->route('refunds.index');
          }

        public function export()
        {

        }

        public function refundsdetail(Refund $refund)
        {

          $refundsdetails['title']=Refunddetail::first();

          $refundsdetails['data']=$refund->refunddetails()->paginate(15);
          $refundsdetails['data']->refund=$refund;
//           $refundsdetails['data']=$refund->load(['refunddetails' => function ($query) {
//     $query->get()->toArray();
// }]);
        //  dd($refundsdetails['data']);
          return view('refunds.refundsdetail',['refundsdetails'=>$refundsdetails,'current_url'=>$this->request->url()]);
        }

        public function rowupdate(Refund $refund)
        {
          // dd($refund);
          // dd($this->request->except('_token'));
          //dd(Auth::user()->hasAnyRole(['高级管理员','站长']));
          // if(!Auth::user()->hasAnyRole(['高级管理员','站长']))
          // $this->authorize('updateanddestroy', $settlement);
           $refund->update($this->request->except('_token'));
          session()->flash('success', '恭喜你，更新数据成功！');
          // $data['name']=Auth::user()->name;
          // $data['order_number']=$refund->order_number;
          // $data['project_number']=$refund->project_number;
          // $data['type']='结算';
          // $mes='修改了';
          // $mes2=event(new ModifyDates($data,$mes));
          //dd($mes2);
          //broadcast(new ChangeOrder(Auth::user(),$refund->order_number,"刚刚修改了订单编号为",$mes2));
          return redirect()->back();
        }

        public function destroy(Refund $refund)
        {
          //dd($refunddetail);
          $refundadn=$refund->audit_document_number;
          $refundpn=$refund->project_number;
          if($refund->refunddetails->isNotEmpty())
          {
            session()->flash('warning', '删除失败！此物资条目下存在多种具体物资，请先删除所有子类具体物资，否则无法删除此条目！');
            return redirect()->route('refunds.index');
          }
          $refund->delete();
          // $data['name']=Auth::user()->name;
          // $data['audit_document_number']=$refunddetailadn;
          // $data['project_number']=$refunddetailpn;
          // $data['type']='物资详情';
          // $mes='删除了';
          //$mes2=event(new ModifyDates($data,$mes));
          //broadcast(new ChangeOrder(Auth::user(),$Settlementodn,"刚刚删除了订单编号为",$mes2));
          session()->flash('success', '恭喜你，删除成功！');
          return redirect()->route('refunds.index');

        }



}
