<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Settlement;
use App\Models\User;
use App\Handlers\ExcelUploadHandler;
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
          return redirect()->back();
      }


      public function rowupdate(Settlement $settlement)
      {
        //dd($this->request->all());
        Settlement::where('id',$settlement->id)->update($this->request->except('_token'));
        session()->flash('success', '恭喜你，更新数据成功！');
        return redirect()->back();
      }

      public function destroy(Settlement $settlement)
      {
        //dd($settlement->id);
        $settlement->delete();
        session()->flash('success', '恭喜你，删除成功！');
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
        return redirect()->route('settlements.index');
        }

      public function smsmail()
        {


          $data=DB::table('settlements')->where('order_number','<>','订单编号')->select(DB::raw('count(*) as num,count(DISTINCT project_number) as project_num,project_manager,audit_progress'))->groupBy('project_manager','audit_progress')->get();
          $data2=DB::table('settlements')->where('order_number','<>','订单编号')->select(DB::raw('count(*) as order_num,count(DISTINCT project_number) as project_num,project_manager'))->groupBy('project_manager')->get();

          foreach ($data2 as $value) {
            $newdata2[$value->project_manager]['order_num']=  $value->order_num;
            $newdata2[$value->project_manager]['project_num']=  $value->project_num;
          }
          //dd($newdata2);

          foreach ($data as $value) {
            $newdata[$value->project_manager][$value->audit_progress]=$value->num;
          }
          //dd(array_merge_recursive($newdata,$newdata2));

          return view('settlements.smsmail',['current_url'=>$this->request->url(),'datas'=>array_merge_recursive($newdata,$newdata2)]);
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
              $settlements['data'] = Settlement::where('order_number','<>','订单编号')->where('project_manager',$name)->orderBy($order,'desc')->paginate($page);
              //dd($this->request->url());
              return view('settlements.smsmaildetail',['current_url'=>$this->request->url(),'settlements'=>$settlements,'querytoarray'=>$querytoarray]);
          }

          protected function sendEmailReminderTo($emailinfo,$username)
        {

      //  dd($emailinfo);
        dd($username);
            parse_str($query,$querytoarray);
            $user=User::where('name',$username)->get();
            dd($user);
            $view = 'emails.settlementmail';
            $data = compact('user');
            $from = '253251551@qq.com';
            $name = 'sample';
            $to = $user->email;
            $subject = "感谢注册 工程部审计 应用！请确认你的邮箱。";

            Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
                $message->from($from, $name)->to($to)->subject($subject);
            });
        }

}
