<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Refund;
use Illuminate\Support\Facades\DB;
use App\Models\Refunddetail;
use App\Models\Refundtime;
use App\Handlers\ExcelUploadHandler;
use App\Models\User;
use Carbon\Carbon;
use App\Events\ModifyDates;
use App\Events\ChangeOrder;
use App\Models\Trace;
use Mail;
use Auth;

class RefundsController extends Controller
{
  protected $request;
  public function __construct(Request $request)
  {
      $this->middleware('auth');
      $this->middleware('check');
      $this->request=$request;
  }

  public function index()
    {
      //dd(parse_url('postgres://qkhdklcjrqaipc:df01a2f558215a0a7829c6aec0d4fc22e90a5def129294f53e08e42a3a97c911@ec2-54-235-66-81.compute-1.amazonaws.com:5432/d34bjielr59n77'));
        $page=8;
        $refunds['title'] = Refund::first();

        $query=$this->request->input('query');
        //dd($query);
        if($query)
          $refunds['data'] = Refund::search($query)->paginate($page);
        else

          $refunds['data'] = Refund::where('audit_report_name','<>','审计报告名称')->orderBy('id','asc')->paginate($page);


        $tracesdata=Trace::where('type','物资')->orWhere('type','物资详情')->orWhere('type','项目经理物资详情导入')->orderBy('created_at','desc')->get();
        if($tracesdata->isEmpty()){
          return view('refunds.index',['current_url'=>$this->request->url(),'refunds'=>$refunds,'traces'=>[]]);
        }
        //dd($traces);
        //dd($refunds);
        foreach ($tracesdata as $value) {
          $traces[$value->year.'年'.$value->month.'月'][]=$value;
        }

        //dd($traces);
        return view('refunds.index',['current_url'=>$this->request->url(),'refunds'=>$refunds,'traces'=>$traces]);
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
            return view('refunds.create',['current_url'=>$this->request->url()]);
        }

        public function store()
          {

          // $datarequest=$this->request->except('_token');
          // dd($datarequest);
          $this->validate($this->request, [
             'project_number' => 'required',
             'audit_document_number' => 'required',
         ],['project_number.required' => '“项目编号”不能不填！',
            'audit_document_number.required' => '“文号（文件字号）”不能不填！',
               ]);
          $datarequest=$this->request->except('_token');
          $refund=Refund::create($datarequest);
          $data['name']=Auth::user()->name;
          $data['project_number']=$refund->project_number;
          $data['audit_document_number']=$refund->audit_document_number;
          $data['type']='物资';
          $mes='新增了';
          $mes2=event(new ModifyDates($data,$mes));
          broadcast(new ChangeOrder(Auth::user(),"项目编号为".$refund->project_number."且审计文号为".$refund->audit_document_number."的退库条目","刚刚新增了",$mes2));
          session()->flash('success', '恭喜你，添加数据成功！');
          return redirect()->route('refunds.index');
          }

        public function export()
        {
          $refunds=Refund::all()->toArray();
          //dd($refunds);
          $upload=new ExcelUploadHandler;
          $upload->download($refunds,'物资退库总表');
        }

        public function exportdetails()
        {
          $refunddetails=Refunddetail::all()->toArray();
          //dd($refunds);
          $upload=new ExcelUploadHandler;
          $upload->download($refunddetails,'退库物资详情总表');
        }

        public function refundsdetail(Refund $refund)
        {
          //dd($refund);
          $audit_document_number=$refund->audit_document_number;
          $project_number=$refund->project_number;
          $refundsdetails['title']=Refunddetail::first();
          $refundsdetails['data']=$refund->refunddetails()->orderBy('construction_enterprise')->paginate(10);
          $refundsdetails['data']->refund=$refund;
          $refunddetails_total = DB::table('refunddetails')->where('audit_document_number',$audit_document_number)->where('project_number',$project_number)->select(DB::raw('sum(subtraction_cost) as construction_should_refund_total,sum(refund_cost) as thing_refund_total,sum(cash_refund) as cash_refund_total,sum(unrefund_cost) as unrefund_cost_total'))->first();
          //dd($refunddetails_total);
//           $refundsdetails['data']=$refund->load(['refunddetails' => function ($query) {
//     $query->get()->toArray();
// }]);
        //  dd($refundsdetails['data']);
          return view('refunds.refundsdetail',['refunddetails_total'=>$refunddetails_total,'refundsdetails'=>$refundsdetails,'current_url'=>$this->request->url()]);
        }

        public function rowupdate(Refund $refund)
        {
          // dd($refund);
          // dd($this->request->except('_token'));
          //dd(Auth::user()->hasAnyRole(['高级管理员','站长']));
          if(!Auth::user()->hasAnyRole(['高级管理员','站长']))
          $this->authorize('updateanddestroy', $refund);
           $refund->update($this->request->except('_token'));

          $data['name']=Auth::user()->name;
          $data['project_number']=$refund->project_number;
          $data['audit_document_number']=$refund->audit_document_number;
          $data['type']='物资';
          $mes='修改了';
          $mes2=event(new ModifyDates($data,$mes));
          broadcast(new ChangeOrder(Auth::user(),"项目编号为".$refund->project_number."且审计文号为".$refund->audit_document_number."的退库条目","刚刚更新了",$mes2));
          session()->flash('success', '恭喜你，更新数据成功！');
          return redirect()->back();
        }

        public function destroy(Refund $refund)
        {
          //dd($refunddetail);
          if(!Auth::user()->hasAnyRole(['高级管理员','站长']))
          $this->authorize('updateanddestroy', $refund);
          $refundadn=$refund->audit_document_number;
          $refundpn=$refund->project_number;
          if($refund->refunddetails->isNotEmpty())
          {
            session()->flash('warning', '删除失败！此物资条目下存在多种具体物资，请先删除所有子类具体物资，否则无法删除此条目！');
            return redirect()->route('refunds.index');
          }
          $refund->delete();
          $data['name']=Auth::user()->name;
          $data['project_number']=$refund->project_number;
          $data['audit_document_number']=$refund->audit_document_number;
          $data['type']='物资';
          $mes='删除了';
          $mes2=event(new ModifyDates($data,$mes));
          broadcast(new ChangeOrder(Auth::user(),"项目编号为".$refund->project_number."且审计文号为".$refund->audit_document_number."的退库条目","刚刚删除了",$mes2));
          session()->flash('success', '恭喜你，删除成功！');
          return redirect()->route('refunds.index');

        }

        public function smsmail()
            {

    //以项目经理分组查询，带上项目经理的物资退库信息
              $datas=DB::table('refunds')->where('project_number','<>','项目编号')->select(DB::raw('count(DISTINCT project_number) as project_num,sum(construction_should_refund) as construction_should_refund_total,sum(thing_refund) as thing_refund_total,sum(cash_refund) as cash_refund_total,sum(direct_yes) as direct_yes_total,sum(direct_no) as direct_no_total,sum(unrefund_cost) as unrefund_cost_total,project_manager'))->groupBy('project_manager')->get();

              if($datas->isEmpty())
              {
                return view('refunds.smsmail',['current_url'=>$this->request->url(),'datas'=>[]]);
              }


              //得到项目经理的联系方式（如微信、邮箱、手机号）
              foreach($datas as $data)
              {
                if(strpos($data->project_manager,'、'))
                {
                  $tems=explode("、",$data->project_manager);
                  foreach($tems as $tem)
                  {
                    if($user=User::where('name',$tem)->first()){
                      $data->notification_information[$tem]=$user->email;
                      $data->weixin_notification_information[$tem]=$user->openid;
                    }

                    else{
                      $data->notification_information[$tem]='';
                      $data->weixin_notification_information[$tem]='';
                    }

                  }
                }
                else {
                  $tem=$data->project_manager;
                  if($user=User::where('name',$tem)->first()){
                    $data->notification_information[$tem]=$user->email;
                    $data->weixin_notification_information[$tem]=$user->openid;
                  }

                  else
                  {
                    $data->notification_information[$tem]='';
                    $data->weixin_notification_information[$tem]='';
                  }

                }
              //dd(http_build_query($data));
                $float_construction_should_refund_total=floatval($data->construction_should_refund_total);
                if($float_construction_should_refund_total!==0.0)
                {
                  $rate=1-$data->unrefund_cost_total/$data->construction_should_refund_total;
                  $data->refund_rate=sprintf("%01.2f", $rate*100).'%';
                }
                else
                  $data->refund_rate='未定义';
              }





              //以专业室分组查询
              $datas2=DB::table('refunds')->where('project_number','<>','项目编号')->select(DB::raw('count(DISTINCT project_number) as project_num,sum(construction_should_refund) as construction_should_refund_total,sum(thing_refund) as thing_refund_total,sum(cash_refund) as cash_refund_total,sum(direct_yes) as direct_yes_total,sum(direct_no) as direct_no_total,sum(unrefund_cost) as unrefund_cost_total,professional_room'))->groupBy('professional_room')->get();
              //dd($datas2);

              return view('refunds.smsmail',['current_url'=>$this->request->url(),'datas'=>$datas,'datas2'=>$datas2]);
            }


            public function smsmaildetail()
              {

                $query=$this->request->getQueryString();
                parse_str($query,$querytoarray);
                $order=(isset($querytoarray['order'])&&$querytoarray['order']==2)?'audit_document_number':'project_number';

                //dd($querytoarray);
                  $name=$this->request->query('name');



                    $page=8;
                    $refunds['title'] = Refund::first();
                    if($querytoarray['type']==1)
                    {
                      if(Refund::where('project_manager',$name)->get()->isEmpty()){
                        session()->flash('info', '你已删除项目经理为'.$name.'的所有结算审计的内容！');
                        return redirect()->route('settlements.smsmail');
                      }
                      $refunds['data'] = Refund::where('project_number','<>','项目编号')->where('project_manager',$name)->orderBy($order,'desc')->paginate($page);
                    }

                    elseif($querytoarray['type']==2)
                    {
                      if(Refund::where('audit_company',$name)->get()->isEmpty()){
                        session()->flash('info', '你已删除审计公司为'.$name.'的所有结算审计的内容！');
                        return redirect()->route('settlements.smsmail');
                      }
                      $refunds['data'] = Refund::where('project_number','<>','项目编号')->where('audit_company',$name)->orderBy($order,'desc')->paginate($page);
                      //dd($refunds['data']);
                    }
                    //dd($querytoarray);
                    return view('refunds.smsmaildetail',['current_url'=>$this->request->url(),'refunds'=>$refunds,'querytoarray'=>$querytoarray]);

              }

              public function exportbytype()
                {
                    $typeinfo=$this->request->query();
                    //dd($typeinfo);
                    $refunds=Refund::where('project_number','项目编号')->orWhere($typeinfo)->get()->toArray();
                    dd($refunds);
                    $upload=new ExcelUploadHandler;
                    $upload->download($refunds,'物资管理分表');

                }


              public function sendEmailReminderTo()
            {


                 $emailinfo=$this->request->query();
                 $querytoarray=json_decode($emailinfo['emailinfo'],true);
                //dd($emailinfo);
                // if($emailinfo['email']=='')
                // {
                //   session()->flash('danger', '发送失败 ！项目经理邮箱不能为空');
                //   return redirect()->back();
                //
                // }


                $filename=$querytoarray['project_manager'].'的物资退库情况表('.Carbon::now()->format('Y-m-d H_i_s').')';
                //$filename='13:11:55';
                //dd($filename);
                $refunds = Refund::where('project_number','项目编号')->orWhere('project_manager',$querytoarray['project_manager'])->get();
                //dd($refunds);
                $upload=new ExcelUploadHandler;
                $upload->exporttoserver($refunds,$filename);

                //dd($emailinfo);
                $view = 'emails.refundsmail';
                $data = compact('querytoarray');
                $from = '253251551@qq.com';
                $name = 'sample';

                $subject = "请抓紧完成物资退库！";
                $attach=storage_path('exports/'.$filename.'.xls');
                foreach ($emailinfo as $key => $value) {
                  if($key!='emailinfo'){
                  $to=$value;
                  Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject,$attach) {
                      $message->from($from, $name)->to($to)->subject($subject)->attach($attach);
                  });
                }
              }

                session()->flash('success', '发送成功！');
                return redirect()->back();
            }
//
            public function statistics()
          {
            $newdata=Refundtime::orderBy('created_at', 'desc')->take(7)->get()->toArray();
            //dd($newdata);
            $newdata=my_sort($newdata,'created_at',SORT_ASC,SORT_REGULAR );
            if(!$newdata)
            {
              $data=json_encode([]);
              return view('refunds.statistics',['current_url'=>$this->request->url(),'data'=>$data]);
            }
            foreach ($newdata as $key => $value) {
              $data['xaxis'][]=$value['created_at'];
              $data['data']['实物退库'][]=$value['实物退库'];
              $data['data']['现金退库'][]=$value['现金退库'];
              $data['data']['施工单位直接用于其它工程（有退库领用手续）'][]=$value['施工单位直接用于其它工程（有退库领用手续）'];
              $data['data']['施工单位直接用于其它工程（无退库领用手续）'][]=$value['施工单位直接用于其它工程（无退库领用手续）'];
              $data['data']['未退库金额'][]=$value['未退库金额'];
            }
            //dd($data);

            $data=json_encode($data);
            return view('refunds.statistics',['current_url'=>$this->request->url(),'data'=>$data]);
          }



}
