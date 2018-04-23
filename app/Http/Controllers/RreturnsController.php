<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Rreturn;
use App\Handlers\ExcelUploadHandler;
use App\Events\ChangeOrder;
use App\Events\ModifyDates;
use App\Models\Trace;
use App\Models\Rreturntime;
use Carbon\Carbon;
use Auth;
use Mail;

class RreturnsController extends Controller
{
  protected $request;
  public function __construct(Request $request)
  {
      $this->middleware('auth');
      $this->middleware('check');
      $this->request=$request;
  }

  public function importpage()
    {
        // $page=10;
        // $rreturns = Rreturn::paginate($page);

        return view('rreturns.importpage',['current_url'=>$this->request->url()]);
    }

    public function import()
      {
          Rreturn::truncate();
          //dd('已经清空');
          $file=$this->request->file('excel');
          $upload=new ExcelUploadHandler;
          $data=$upload->save($file);
          //dd($data);
          DB::table('rreturns')->insert($data);
          session()->flash('success', '恭喜你，导入数据成功！');

          return redirect()->back();
      }

      public function export()
        {
            $rreturns=Rreturn::all()->toArray();
            //dd($rreturns);
            $upload=new ExcelUploadHandler;
            $upload->download($rreturns,'决算审计总表');
        }

        public function exportbytype()
          {
              $typeinfo=$this->request->query();
              $rreturns=Rreturn::where('project_number','项目编号')->orWhere($typeinfo)->get()->toArray();
              $upload=new ExcelUploadHandler;
              $upload->download($rreturns,'决算审计分表');

          }

      public function index()
        {
            $page=10;
            $rreturns['title'] = Rreturn::first();
            $query=$this->request->input('query');
            if($query)
              $rreturns['data'] = Rreturn::search($query)->paginate($page);
            else
              $rreturns['data'] = Rreturn::where('project_number','<>','项目编号')->paginate($page);

            $tracesdata=Trace::where('type','决算')->orderBy('created_at','desc')->get();
            if($tracesdata->isEmpty()){
              return view('rreturns.index',['current_url'=>$this->request->url(),'rreturns'=>$rreturns,'traces'=>[]]);
            }

            foreach ($tracesdata as $value) {
              $traces[$value->year.'年'.$value->month.'月'][]=$value;
            }

            //dd($traces);
            return view('rreturns.index',['current_url'=>$this->request->url(),'rreturns'=>$rreturns,'traces'=>$traces]);//'traces'=>$traces
        }

        public function rowupdate(Rreturn $rreturn)
        {
          //dd($this->request->all());
          if(!Auth::user()->hasAnyRole(['高级管理员','站长']))
          $this->authorize('updateanddestroy', $rreturn);
          Rreturn::where('id',$rreturn->id)->update($this->request->except('_token'));
          session()->flash('success', '恭喜你，更新数据成功！');
          $data['name']=Auth::user()->name;
          $data['project_number']=$rreturn->project_number;
          $data['type']='决算';
          $mes='修改了';
          $mes2=event(new ModifyDates($data,$mes));
          broadcast(new ChangeOrder(Auth::user(),$rreturn->project_number,"刚刚修改了项目编号为",$mes2));
          return redirect()->back();
        }

        public function destroy(Rreturn $rreturn)
        {
          //dd($rreturn->id);
          if(!Auth::user()->hasAnyRole(['高级管理员','站长']))
          $this->authorize('updateanddestroy', $rreturn);
          $rreturnodn=$rreturn->project_number;
          $rreturn->delete();
          $data['name']=Auth::user()->name;
          $data['project_number']=$rreturnodn;
          $data['type']='决算';
          $mes='删除了';
          $mes2=event(new ModifyDates($data,$mes));
          broadcast(new ChangeOrder(Auth::user(),$rreturnodn,"刚刚删除了项目编号为",$mes2));
          session()->flash('success', '恭喜你，删除成功！');
          return redirect()->back();

        }

        public function create()
          {

              return view('rreturns.create');
          }

        public function store()
          {
          $datarequest=$this->request->except('_token');
          $rreturn=Rreturn::create($datarequest);
          $data['name']=Auth::user()->name;
          $data['project_number']=$rreturn->project_number;
          $data['type']='决算';
          $mes='新建了';
          $mes2=event(new ModifyDates($data,$mes));
          session()->flash('success', '恭喜你，添加数据成功！');
          broadcast(new ChangeOrder(Auth::user(),$rreturn->project_number,"刚刚新增了项目编号为",$mes2));
          return redirect()->route('rreturns.index');
          }



          public function smsmail()
            {

    //以项目经理和审计进度分组查询，带上项目经理的订单和项目数信息
              $data=DB::table('rreturns')->where('project_number','<>','项目编号')->select(DB::raw('count(*) as num,project_manager,audit_progress'))->groupBy('project_manager','audit_progress')->get();
              $data2=DB::table('rreturns')->where('project_number','<>','项目编号')->select(DB::raw('count(DISTINCT project_number) as project_num,project_manager'))->groupBy('project_manager')->get();
    //如果没有数据返回空数组
              if($data->isEmpty()||$data2->isEmpty())
              {
                return view('rreturns.smsmail',['current_url'=>$this->request->url(),'datas'=>[],'datas2'=>[]]);
              }

              foreach ($data2 as $value) {
                //$newdata2[$value->project_manager]['order_num']=  $value->order_num;
                $newdata2[$value->project_manager]['project_num']=  $value->project_num;
              }
              foreach ($data as $value) {
                $newdata[$value->project_manager][$value->audit_progress]=$value->num;
              }

    //以审计单位和审计进度分组查询，带上审计单位的订单数信息
              $data3=DB::table('rreturns')->where('project_number','<>','项目编号')->select(DB::raw('count(*) as num,audit_company,audit_progress'))->groupBy('audit_company','audit_progress')->get();
              $data4=DB::table('rreturns')->where('project_number','<>','项目编号')->select(DB::raw('count(DISTINCT project_number) as project_num,audit_company'))->groupBy('audit_company')->get();

              foreach ($data4 as $value) {
                //$newdata4[$value->audit_company]['order_num']=  $value->order_num;
                $newdata4[$value->audit_company]['project_num']=  $value->project_num;
              }
              foreach ($data3 as $value) {
                $newdata3[$value->audit_company][$value->audit_progress]=$value->num;
              }

              return view('rreturns.smsmail',['current_url'=>$this->request->url(),'datas'=>array_merge_recursive($newdata,$newdata2),'datas2'=>array_merge_recursive($newdata3,$newdata4)]);
            }


            public function smsmaildetail()
              {

                $query=$this->request->getQueryString();
                parse_str($query,$querytoarray);
                $order=(isset($querytoarray['order'])&&$querytoarray['order']==2)?'project_number':'audit_progress';

                //dd($querytoarray);
                  $name=$this->request->query('name');

                  $page=10;
                  $rreturns['title'] = Rreturn::first();
                  if($querytoarray['type']==1)
                  {
                    if(Rreturn::where('project_manager',$name)->get()->isEmpty()){
                      session()->flash('info', '你已删除项目经理为'.$name.'的所有决算审计的内容！');
                      return redirect()->route('rreturns.smsmail');
                    }
                    $rreturns['data'] = Rreturn::where('project_number','<>','项目编号')->where('project_manager',$name)->orderBy($order,'desc')->paginate($page);
                  }

                  elseif($querytoarray['type']==2)
                  {
                    if(Rreturn::where('audit_company',$name)->get()->isEmpty()){
                      session()->flash('info', '你已删除审计公司为'.$name.'的所有决算审计的内容！');
                      return redirect()->route('rreturns.smsmail');
                    }
                    $rreturns['data'] = Rreturn::where('project_number','<>','项目编号')->where('audit_company',$name)->orderBy($order,'desc')->paginate($page);
                  }

                  //dd($rreturns['data']);
                  return view('rreturns.smsmaildetail',['current_url'=>$this->request->url(),'rreturns'=>$rreturns,'querytoarray'=>$querytoarray]);
              }


              public function sendEmailReminderTo()
            {


                $emailinfo=$this->request->query();
                //dd($emailinfo['email']);
                if($emailinfo['email']=='')
                {
                  session()->flash('danger', '发送失败 ！项目经理邮箱不能为空');
                  return redirect()->back();

                }
                parse_str($emailinfo['emailinfo'],$querytoarray);

                $filename=$querytoarray['manager'].'的决算审计表('.Carbon::now()->format('Y-m-d H_i_s').')';
                //dd($filename);
                $rreturns = Rreturn::where('project_number','项目编号')->orWhere('project_manager',$querytoarray['manager'])->get();
                $upload=new ExcelUploadHandler;
                $upload->exporttoserver($rreturns,$filename);


                //dd($emailinfo);
                $view = 'emails.rreturnsmail';
                $data = compact('querytoarray');
                $from = '253251551@qq.com';
                $name = 'sample';
                $to = $emailinfo['email'];
                $subject = "请抓紧完成决算审计！";
                $attach=storage_path('exports/'.$filename.'.xls');

                Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject,$attach) {
                    $message->from($from, $name)->to($to)->subject($subject)->attach($attach);
                });
                session()->flash('success', '发送成功！');
                return redirect()->back();
            }



            public function statistics()
          {
            $newdata=Rreturntime::orderBy('created_at', 'desc')->take(7)->get()->toArray();
          //  dd($newdata);
            if(!$newdata)
            {
              $data=json_encode([]);
              return view('rreturns.statistics',['current_url'=>$this->request->url(),'data'=>$data]);
            }
            foreach ($newdata as $key => $value) {
              $data['xaxis'][]=$value['created_at'];
              $data['data']['不具备决算送审条件'][]=$value['不具备决算送审条件'];
              $data['data']['具备送审条件未送审'][]=$value['具备送审条件未送审'];
              $data['data']['被退回'][]=$value['被退回'];
              $data['data']['审计中'][]=$value['审计中'];
              $data['data']['已出报告'][]=$value['已出报告'];
            }
            $data=json_encode($data);
            //dd($data);

            return view('rreturns.statistics',['current_url'=>$this->request->url(),'data'=>$data]);

          }






}
