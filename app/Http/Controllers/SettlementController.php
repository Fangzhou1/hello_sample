<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Settlement;
use App\Models\Settlementtime;
use App\Models\User;
use App\Models\Trace;
use App\Handlers\ExcelUploadHandler;
use Carbon\Carbon;
use App\Events\ChangeOrder;
use App\Events\ModifyDates;
use Mail;
use Auth;



class SettlementController extends Controller
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
        $page=10;
        $settlements['title'] = Settlement::first();
        $query=$this->request->input('query');
        //dd($query);
        if($query)
          $settlements['data'] = Settlement::search($query)->paginate($page);
        else
          $settlements['data'] = Settlement::where('order_number','<>','订单编号')->paginate($page);

        $tracesdata=Trace::where('type','结算')->orderBy('created_at','desc')->get();
        if($tracesdata->isEmpty()){
          return view('settlements.index',['current_url'=>$this->request->url(),'settlements'=>$settlements,'traces'=>[]]);
        }
        //dd($traces);
        //dd($settlements);
        foreach ($tracesdata as $value) {
          $traces[$value->year.'年'.$value->month.'月'][]=$value;
        }

        //dd($traces);
        return view('settlements.index',['current_url'=>$this->request->url(),'settlements'=>$settlements,'traces'=>$traces]);
    }

  public function importpage()
    {
        // $page=10;
        // $settlements = Settlement::paginate($page);

        return view('settlements.importpage',['current_url'=>$this->request->url()]);
    }

    public function import()
      {
          Settlement::truncate();
          //dd('已经清空');
          $file=$this->request->file('excel');
          $upload=new ExcelUploadHandler;
          $data=$upload->save($file);
          //dd($data);
          $this->batchimport($data);
          //session()->flash('success', '恭喜你，导入数据成功！');

          return redirect()->back();
      }

      public function export()
        {
            $settlement=Settlement::all()->toArray();
            //dd($settlement);
            $upload=new ExcelUploadHandler;
            $upload->download($settlement,'结算审计总表');

        }

        public function exportbytype()
          {
              $typeinfo=$this->request->query();
              $settlement=Settlement::where('order_number','订单编号')->orWhere($typeinfo)->get()->toArray();
              $upload=new ExcelUploadHandler;
              $upload->download($settlement,'结算审计分表');

          }

      public function rowupdate(Settlement $settlement)
      {
        //dd(Auth::user()->hasAnyRole(['高级管理员','站长']));
        if(!Auth::user()->hasAnyRole(['高级管理员','站长']))
        $this->authorize('updateanddestroy', $settlement);
        Settlement::where('id',$settlement->id)->update($this->request->except('_token'));
        session()->flash('success', '恭喜你，更新数据成功！');
        $data['name']=Auth::user()->name;
        $data['order_number']=$settlement->order_number;
        $data['project_number']=$settlement->project_number;
        $data['type']='结算';
        $mes='修改了';
        $mes2=event(new ModifyDates($data,$mes));
        //dd($mes2);
        broadcast(new ChangeOrder(Auth::user(),$settlement->order_number,"刚刚修改了订单编号为",$mes2));
        return redirect()->back();
      }

      public function destroy(Settlement $settlement)
      {
        //dd($settlement->id);
        if(!Auth::user()->hasAnyRole(['高级管理员','站长']))
        $this->authorize('updateanddestroy', $settlement);
        $Settlementodn=$settlement->order_number;
        $settlement->delete();
        $data['name']=Auth::user()->name;
        $data['order_number']=$Settlementodn;
        $data['project_number']=$settlement->project_number;
        $data['type']='结算';
        $mes='删除了';
        $mes2=event(new ModifyDates($data,$mes));
        broadcast(new ChangeOrder(Auth::user(),$Settlementodn,"刚刚删除了订单编号为",$mes2));
        session()->flash('success', '恭喜你，删除成功！');
        return redirect()->back();
      }

      public function create()
        {

            return view('settlements.create');
        }

      public function store()
        {
        $datarequest=$this->request->except('_token');
        $settlement=Settlement::create($datarequest);
        $data['name']=Auth::user()->name;
        $data['order_number']=$settlement->order_number;
        $data['project_number']=$settlement->project_number;
        $data['type']='结算';
        $mes='新建了';
        $mes2=event(new ModifyDates($data,$mes));
        session()->flash('success', '恭喜你，添加数据成功！');
        broadcast(new ChangeOrder(Auth::user(),$settlement->order_number,"刚刚新增了订单编号为",$mes2));
        return redirect()->route('settlements.index');
        }

      public function smsmail()
        {
//以项目经理和审计进度分组查询，带上项目经理的订单和项目数信息
          $data=DB::table('settlements')->where('order_number','<>','订单编号')->select(DB::raw('count(*) as num,project_manager,audit_progress'))->groupBy('project_manager','audit_progress')->get();
          $data2=DB::table('settlements')->where('order_number','<>','订单编号')->select(DB::raw('count(*) as order_num,count(DISTINCT project_number) as project_num,project_manager'))->groupBy('project_manager')->get();
//如果没有数据返回空数组
          if($data->isEmpty()||$data2->isEmpty())
          {
            return view('settlements.smsmail',['current_url'=>$this->request->url(),'datas'=>[],'datas2'=>[]]);
          }
          //dd($data2);
          foreach ($data2 as $key=>$value) {
            $newdata2[$value->project_manager]['order_num']=  $value->order_num;
            $newdata2[$value->project_manager]['project_num']=  $value->project_num;
            $newdata2[$value->project_manager]['project_manager']= $value->project_manager;
          }
          foreach ($data as $value) {
            $newdata[$value->project_manager][$value->audit_progress]=$value->num;
            //加入项目经理的微信和邮箱信息
            if(strpos($value->project_manager,'、'))
            {
                $tems=explode("、",$value->project_manager);
                foreach($tems as $tem)
                {
                    if($user=User::where('name',$tem)->first()){
                      $newdata[$value->project_manager]['notification_information'][$tem]=$user->email;
                      $newdata[$value->project_manager]['weixin_notification_information'][$tem]=$user->openid;
                    }
                    else{
                      $newdata[$value->project_manager]['notification_information'][$tem]='';
                      $newdata[$value->project_manager]['weixin_notification_information'][$tem]='';
                    }
                }
            }
          else {
              $tem=$value->project_manager;
              if($user=User::where('name',$tem)->first()){
                $newdata[$value->project_manager]['notification_information'][$tem]=$user->email;
                $newdata[$value->project_manager]['weixin_notification_information'][$tem]=$user->openid;
              }

              else
              {
                $newdata[$value->project_manager]['notification_information'][$tem]='';
                $newdata[$value->project_manager]['weixin_notification_information'][$tem]='';
              }
          }


          }
          //dd($newdata);
//以审计单位和审计进度分组查询，带上审计单位的订单数信息
          $data3=DB::table('settlements')->where('order_number','<>','订单编号')->select(DB::raw('count(*) as num,audit_company,audit_progress'))->groupBy('audit_company','audit_progress')->get();
          $data4=DB::table('settlements')->where('order_number','<>','订单编号')->select(DB::raw('count(*) as order_num,count(DISTINCT project_number) as project_num,audit_company'))->groupBy('audit_company')->get();

          foreach ($data4 as $value) {
            $newdata4[$value->audit_company]['order_num']=  $value->order_num;
            $newdata4[$value->audit_company]['project_num']=  $value->project_num;
          }
          foreach ($data3 as $value) {
            $newdata3[$value->audit_company][$value->audit_progress]=$value->num;
          }
          //dd(array_merge_recursive($newdata,$newdata2));
          return view('settlements.smsmail',['current_url'=>$this->request->url(),'datas'=>array_merge_recursive($newdata,$newdata2),'datas2'=>array_merge_recursive($newdata3,$newdata4)]);
        }

        public function smsmaildetail()
          {

            $query=$this->request->getQueryString();
            parse_str($query,$querytoarray);
            $order=(isset($querytoarray['order'])&&$querytoarray['order']==2)?'project_number':'audit_progress';

            //dd($querytoarray);
              $name=$this->request->query('name');



                $page=10;
                $settlements['title'] = Settlement::first();
                if($querytoarray['type']==1)
                {
                  if(Settlement::where('project_manager',$name)->get()->isEmpty()){
                    session()->flash('info', '你已删除项目经理为'.$name.'的所有结算审计的内容！');
                    return redirect()->route('settlements.smsmail');
                  }
                  $settlements['data'] = Settlement::where('order_number','<>','订单编号')->where('project_manager',$name)->orderBy($order,'desc')->paginate($page);
                }

                elseif($querytoarray['type']==2)
                {
                  if(Settlement::where('audit_company',$name)->get()->isEmpty()){
                    session()->flash('info', '你已删除审计公司为'.$name.'的所有结算审计的内容！');
                    return redirect()->route('settlements.smsmail');
                  }
                  $settlements['data'] = Settlement::where('order_number','<>','订单编号')->where('audit_company',$name)->orderBy($order,'desc')->paginate($page);
                  //dd($settlements['data']);
                }

                return view('settlements.smsmaildetail',['current_url'=>$this->request->url(),'settlements'=>$settlements,'querytoarray'=>$querytoarray]);

          }

          public function sendEmailReminderTo()
        {


            $emailinfo=$this->request->query();
            //dd($emailinfo);
            //dd($emailinfo['email']);
            // if($emailinfo['email']=='')
            // {
            //   session()->flash('danger', '发送失败 ！项目经理邮箱不能为空');
            //   return redirect()->back();
            //
            // }
            $querytoarray=json_decode($emailinfo['emailinfo'],true);
            //dd($querytoarray);
            $filename=$querytoarray['project_manager'].'的结算审计表('.Carbon::now()->format('Y-m-d H_i_s').')';
            //dd($filename);
            $settlements = Settlement::where('order_number','订单编号')->orWhere('project_manager',$querytoarray['project_manager'])->get();
//dd($settlements);
            $upload=new ExcelUploadHandler;
            $upload->exporttoserver($settlements,$filename);

            //dd($emailinfo);
            $view = 'emails.settlementsmail';
            $data = compact('querytoarray');
            $from = '253251551@qq.com';
            $name = 'sample';

            $subject = "请抓紧完成结算审计！";
            $attach=storage_path('exports/'.$filename.'.xls');
            foreach ($emailinfo as $key => $value) {
              if($key!='emailinfo'){
                $to = $value;
                Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject,$attach) {
                    $message->from($from, $name)->to($to)->subject($subject)->attach($attach);
                });
              }
            }

            session()->flash('success', '发送成功！');
            return redirect()->back();
        }

        public function statistics()
      {

        //结算审计订单情况统计
        $data1=DB::table('settlements')->where('order_number','<>','订单编号')->select(DB::raw('count(*) as ordernum,audit_progress'))->groupBy('audit_progress')->get();
        //如果没有数据返回空数组
        if($data1->isEmpty())
        {
          return view('settlements.statistics',['current_url'=>$this->request->url(),'newdata1'=>[],'newdata2'=>[],'newdata3'=>[]]);
        }

        foreach ($data1 as $value) {
          $newdata1[$value->audit_progress]=$value->ordernum;
        }
        //结算审计项目情况统计
        $data3=DB::table('settlements')->where('order_number','<>','订单编号')->select(DB::raw('count(*) as ordernum,audit_progress,project_number'))->groupBy('project_number','audit_progress')->get();
        //dd($data3);
        foreach ($data3 as $value) {
          $newdata_tem[$value->project_number][$value->audit_progress]=$value->ordernum;
        }
        //dd($newdata_tem);

        $newdata3=['未送审'=>0,'审计中'=>0,'已完成'=>0];
        foreach ($newdata_tem as $value) {
          if(!(isset($value['审计中'])||isset($value['已出报告'])||isset($value['被退回'])))
            $newdata3['未送审']+=1;
          elseif(isset($value['审计中'])||isset($value['被退回']))
            $newdata3['审计中']+=1;
          else
            $newdata3['已完成']+=1;

        }

        //结算审计项目随时间进度统计
        $newdata_tem=Settlementtime::orderBy('created_at', 'desc')->take(7)->get()->toArray();
        if($newdata_tem==[])
        $newdata2=[];
        else {
          $newdata_tem=$this->my_sort($newdata_tem,'created_at',SORT_ASC,SORT_REGULAR );
          //dd($newdata_tem);
          foreach ($newdata_tem as $value) {

            $newdata2['xdata'][]=substr($value['created_at'],0,10);
            $newdata2['ydata_ordernum'][]=$value['finished_ordernum'];
            $newdata2['ydata_projectnum'][]=$value['finished_projectnum'];
          //  $newdata21=array_multisort($newdata2['xdata'],SORT_ASC,$newdata2);
          }
          $newdata2['ydata_ordernum']=implode(",",$newdata2['ydata_ordernum']);
          $newdata2['ydata_projectnum']=implode(",",$newdata2['ydata_projectnum']);
        }


        return view('settlements.statistics',['current_url'=>$this->request->url(),'newdata1'=>$newdata1,'newdata3'=>$newdata3,'newdata2'=>$newdata2]);
      }



      protected function my_sort($arrays,$sort_key,$sort_order=SORT_ASC,$sort_type=SORT_NUMERIC ){
        if(is_array($arrays)){
            foreach ($arrays as $array){
                if(is_array($array)){
                    $key_arrays[] = $array[$sort_key];
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
        array_multisort($key_arrays,$sort_order,$sort_type,$arrays);
        return $arrays;
    }

    public function search()
      {
          $query=$this->request->input('query');
          $page=10;
          $settlements['title'] = Settlement::first();
          $settlements['data'] = Settlement::search($query)->paginate($page);
          //dd($settlements['data']);
          $tracesdata=Trace::where('type','结算')->orderBy('created_at','desc')->get();
          if($tracesdata->isEmpty()){
            return view('settlements.index',['current_url'=>$this->request->url(),'settlements'=>$settlements,'traces'=>[]]);
          }
          //dd($traces);
          //dd($settlements);
          foreach ($tracesdata as $value) {
            $traces[$value->year.'年'.$value->month.'月'][]=$value;
          }

          //dd($traces);
          return view('settlements.search',['current_url'=>$this->request->url(),'settlements'=>$settlements,'traces'=>$traces]);
      }

      protected function batchimport($data)
      {
        $data_tem=array_slice($data,0,1000);
        $data=array_slice($data,1000);
        DB::table('settlements')->insert($data_tem);
        if($data){
          $this->batchimport($data);
        }
        else {
          session()->flash('success', '恭喜你，导入数据成功！');
        }

      }


}
