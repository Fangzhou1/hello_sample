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
            return;
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

}
