<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Settlement;
use App\Models\Settlementtime;
use App\Models\User;
use App\Handlers\ExcelUploadHandler;
use Carbon\Carbon;
use App\Events\ChangeOrder;
use Mail;
use Auth;



class SettlementController extends Controller
{
  protected $request;
  public function __construct(Request $request)
  {
      $this->middleware('auth');
      $this->request=$request;
  }

  public function index()
    {
        $page=10;
        $settlements['title'] = Settlement::first();
        $settlements['data'] = Settlement::where('order_number','<>','订单编号')->paginate($page);
        //dd($settlements);
        return view('settlements.index',['current_url'=>$this->request->url(),'settlements'=>$settlements]);
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
          DB::table('settlements')->insert($data);
          session()->flash('success', '恭喜你，导入数据成功！');
          broadcast(new ChangeOrder(Auth::user(),$settlement));
          return redirect()->back();
      }


      public function rowupdate(Settlement $settlement)
      {
        //dd($this->request->all());
        Settlement::where('id',$settlement->id)->update($this->request->except('_token'));
        session()->flash('success', '恭喜你，更新数据成功！');
        broadcast(new ChangeOrder(Auth::user(),$settlement));
        return redirect()->back();
      }

      public function destroy(Settlement $settlement)
      {
        //dd($settlement->id);
        $settlement->delete();
        session()->flash('success', '恭喜你，删除成功！');
        broadcast(new ChangeOrder(Auth::id(),$settlement->id));
        return redirect()->back();

      }

      public function create()
        {

            return view('settlements.create');
        }

      public function store()
        {
        $data=$this->request->except('_token');
        Settlement::create($data);
        session()->flash('success', '恭喜你，添加数据成功！');
        broadcast(new ChangeOrder(Auth::id(),$settlement->id));
        return redirect()->route('settlements.index');
        }

      public function smsmail()
        {

//以项目经理和审计进度分组查询，带上项目经理的订单和项目数信息
          $data=DB::table('settlements')->where('order_number','<>','订单编号')->select(DB::raw('count(*) as num,project_manager,audit_progress'))->groupBy('project_manager','audit_progress')->get();
          $data2=DB::table('settlements')->where('order_number','<>','订单编号')->select(DB::raw('count(*) as order_num,count(DISTINCT project_number) as project_num,project_manager'))->groupBy('project_manager')->get();

          foreach ($data2 as $value) {
            $newdata2[$value->project_manager]['order_num']=  $value->order_num;
            $newdata2[$value->project_manager]['project_num']=  $value->project_num;
          }
          foreach ($data as $value) {
            $newdata[$value->project_manager][$value->audit_progress]=$value->num;
          }

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
              $settlements['data'] = Settlement::where('order_number','<>','订单编号')->where('project_manager',$name)->orderBy($order,'desc')->paginate($page);
              elseif($querytoarray['type']==2)
              $settlements['data'] = Settlement::where('order_number','<>','订单编号')->where('audit_company',$name)->orderBy($order,'desc')->paginate($page);
              //dd($settlements['data']);
              return view('settlements.smsmaildetail',['current_url'=>$this->request->url(),'settlements'=>$settlements,'querytoarray'=>$querytoarray]);
          }

          public function sendEmailReminderTo($emailinfo,$username)
        {

        //dd($emailinfo);
      //dd($username);
            parse_str($emailinfo,$querytoarray);
            $user=User::where('name',$username)->first();
            //dd($user);
            $view = 'emails.settlementmail';
            $data = compact('querytoarray');
            $from = '253251551@qq.com';
            $name = 'sample';
            $to = $user->email;
            $subject = "请抓紧完成结算审计！";

            Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
                $message->from($from, $name)->to($to)->subject($subject);
            });
            session()->flash('success', '发送成功！');
            return redirect()->back();
        }

        public function statistics()
      {

        //结算审计订单情况统计
        $data1=DB::table('settlements')->where('order_number','<>','订单编号')->select(DB::raw('count(*) as ordernum,audit_progress'))->groupBy('audit_progress')->get();
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
        //dd($newdata_tem);
        $newdata_tem=$this->my_sort($newdata_tem,'created_at',SORT_ASC,SORT_REGULAR );
        //dd($newdata_tem);
        foreach ($newdata_tem as $value) {

          $newdata2['xdata'][]=substr($value['created_at'],0,10);
          $newdata2['ydata_ordernum'][]=$value['finished_ordernum'];
          $newdata2['ydata_projectnum'][]=$value['finished_projectnum'];
        //  $newdata21=array_multisort($newdata2['xdata'],SORT_ASC,$newdata2);
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


}
