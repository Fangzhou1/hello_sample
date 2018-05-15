<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\Voice;
use Illuminate\Support\Facades\DB;
use App\Models\Loginrecord;
use App\Models\Settlement;
use EasyWeChat;
use Auth;

class WeixinController extends Controller
{
  protected $officialAccount;
  public function __construct(Request $request)
  {
      $this->middleware('auth',['except' => ['index', 'bindWeChat','receiveAuditInfo','createmenu','weixinlogin']]);
      $this->middleware('check',['except' => ['index', 'receiveAuditInfo','createmenu']]);
     $this->officialAccount = EasyWeChat::officialAccount();
  }
  public function index(){
  //  file_put_contents("test.txt","Hello World. Testing!");


    $this->officialAccount->server->push(function ($message) {
      if($message['MsgType']=='event'&&$message['Event']=='subscribe')
        $msg='你好，谢谢你关注工程审计公众号，回复"姓名：您的姓名"完成账号绑定！';
      elseif($message['MsgType']=='event'&&$message['Event']=='CLICK')
      {
        $eventkey=$message['EventKey'];
        $openid=$message['FromUserName'];
        //file_put_contents("test.txt",$eventkey);
        $msg=$this->receiveAuditInfo($eventkey,$openid);
      }
      elseif($message['MsgType']=='text'&&$message['Content']=="进度")
        $msg = new Text('您好！蔡琪祺');
      elseif($message['MsgType']=='text')
      {
        $content1=substr($message['Content'],0,7);
        if($content1=="姓名:")
        {
          $content2=substr($message['Content'],7);
          $openid=$message['FromUserName'];
          $msg=$this->bindWeChat($content2,$openid);
        }
      }
      return $msg;
});
     return $this->officialAccount->server->serve();

  }

  protected function bindWeChat($content,$openid)
  {

    $user1=User::where('name',$content)->first();
    $user2=User::where('openid',$openid)->first();
    //file_put_contents("test.txt",$user1);
    if($user1)
        if($user1->openid==null&&$user2==null)
        {
          $user1->openid=$openid;
          $user1->save();
          $msg='你的微信账号已绑定成功！';
        }
        else
          $msg='你的微信账号已绑定过，请不要重复绑定！';
    else
      $msg='平台中没有您的账号，请先完成注册并联系站长分配权限！';
    return $msg;
  }




  public function sendweixin($type,Request $request){

    $res='';
    $emailinfo=$request->query();
    //dd($emailinfo);
    $querytoarray=json_decode($emailinfo['emailinfo'],true);
    //dd($querytoarray);
    //$users = $this->officialAccount->user->list();
    //dd($users);
    if($type=='结算审计进度'){
      $project_manager=isset($querytoarray['project_manager'])?$querytoarray['project_manager']:'待定项目经理';
      $project_num=isset($querytoarray['project_num'])?$querytoarray['project_num']:0;
      $order_num=isset($querytoarray['order_num'])?$querytoarray['order_num']:0;
      $nosend=isset($querytoarray['未送审'])?$querytoarray['未送审']:0;
      $sending=isset($querytoarray['审计中'])?$querytoarray['审计中']:0;
      $sended=isset($querytoarray['被退回'])?$querytoarray['被退回']:0;
      $finish=isset($querytoarray['已出报告'])?$querytoarray['已出报告']:0;
      $text=$project_manager.'，您好！您的结算审计情况如下：你总共有'.$project_num.'个项目，涉及到'.$order_num.'个订单：未送审：'.$nosend.'个，被退回：'.$sended.'个，审计中：'.$sending.'个，已出报告：'.$finish.'个。';
      foreach ($querytoarray['weixin_notification_information'] as $key => $value) {
        //dd($value);
        if($value){
          $this->officialAccount->customer_service->message($text)->to($value)->send();
          $res.=$key.'微信已发送成功！';
        }
        else
          $res.=$key.'还没有关注微信公众号，需他尽快关注。';
      }

    }
    elseif($type=='决算审计进度')
    {
      $project_manager=isset($querytoarray['project_manager'])?$querytoarray['project_manager']:'待定项目经理';
      $project_num=isset($querytoarray['project_num'])?$querytoarray['project_num']:0;
      $nosend=isset($querytoarray['未送审'])?$querytoarray['未送审']:0;
      $sending=isset($querytoarray['审计中'])?$querytoarray['审计中']:0;
      $sended=isset($querytoarray['被退回'])?$querytoarray['被退回']:0;
      $finish=isset($querytoarray['已出报告'])?$querytoarray['已出报告']:0;
      $text=$project_manager.',你好！您的决算审计情况如下：你总共有'.$project_num.'个项目：未送审：'.$nosend.'个，被退回：'.$sended.'个，审计中：'.$sending.'个，已出报告：'.$finish.'个。';
      foreach ($querytoarray['weixin_notification_information'] as $key => $value) {
        //dd($value);
        if($value){
          $this->officialAccount->customer_service->message($text)->to($value)->send();
          $res.=$key.'微信已发送成功！';
        }
        else
          $res.=$key.'还没有关注微信公众号，需他尽快关注。';
      }
    }
    elseif($type=='物资退库'){
      //dd($type);
      $text=$querytoarray['project_manager'].',你好！您的物资退库情况如下：你总共有'.$querytoarray['project_num'].'项目：应退库：'.$querytoarray['construction_should_refund_total'].'元，实物已退库：'.$querytoarray['thing_refund_total'].'元，现金已退库：'.$querytoarray['cash_refund_total'].'元，直接用于其他工程（有登记）：'.$querytoarray['direct_yes_total'].'元，直接用于其他工程（未登记）：'.$querytoarray['direct_no_total'].'元，未退库：'.$querytoarray['unrefund_cost_total'].'元。';
      //dd($text);

      foreach ($querytoarray['weixin_notification_information'] as $key => $value) {
        //dd($value);
        if($value){
          $this->officialAccount->customer_service->message($text)->to($value)->send();
          $res.=$key.'微信已发送成功！';
        }
        else
          $res.=$key.'还没有关注微信公众号，需他尽快关注。';
      }
    }
    session()->flash('info', $res);
    return redirect()->route('refunds.smsmail');
}

  public function createmenu(){
    $buttons = [
      [
          "name"       => "获取进度",
          "sub_button" => [
              [
                  "type" => "click",
                  "name" => "获取您的结算审计进度",
                  "key" => "V1_SETTLEMENT"
              ],
              [
                  "type" => "click",
                  "name" => "获取您的决算审计进度",
                  "key" => "V1_RRETURN"
              ],
              [
                  "type" => "click",
                  "name" => "获取您的退库物资进度",
                  "key" => "V1_REFUND"
              ],
          ],
      ],
      [
          "type" => "view",
          "name" => "登陆平台",
          "url"  => "http://www.cmccgjb.cn"
      ],
      [
          "type" => "click",
          "name" => "待开发",
          "key"  => "v3"
      ],
    ];
    $this->officialAccount->menu->create($buttons);
  }

  protected function receiveAuditInfo($eventkey,$openid)
  {
    $user=User::where('openid',$openid)->first();
    $data_tem=[];
    //dd($user);
    if($eventkey=='V1_SETTLEMENT')
    {
      $data=DB::table('settlements')->where('project_manager',$user->name)->orWhere('project_manager','like',$user->name.'、%')->orWhere('project_manager','like','%、'.$user->name)->select(DB::raw('count(*) as num,project_manager,audit_progress'))->groupBy('audit_progress','project_manager')->get();
      $data2=DB::table('settlements')->where('project_manager',$user->name)->select(DB::raw('count(*) as order_num,count(DISTINCT project_number) as project_num,project_manager'))->first();
        if($data->isEmpty())
          $text="没有您的数据，请核实情况！";

        else{
        foreach($data as $value)
        {
          if(in_array($value->audit_progress, $data_tem))
            $data_array[$value->audit_progress]+=$value->num;
          else
            $data_array[$value->audit_progress]=$value->num;
          $data_tem[]=$value->audit_progress;
        }
        //dd($data_array);
        $project_manager=$user->name;
        $project_num=$data2->project_num;
        $order_num=$data2->order_num;
        $nosend=$data_array["未送审"];
        $sending=$data_array["审计中"];
        $sended=$data_array["被退回"];
        $finish=$data_array["已出报告"];
        $text=$project_manager.'，您好！您的结算审计情况如下：你总共有'.$project_num.'个项目，涉及到'.$order_num.'个订单：未送审：'.$nosend.'个，被退回：'.$sended.'个，审计中：'.$sending.'个，已出报告：'.$finish.'个。具体请上平台查阅。';
        }
  }
    elseif($eventkey=='V1_RRETURN')
    {
      $data=DB::table('rreturns')->where('project_manager',$user->name)->orWhere('project_manager','like',$user->name.'、%')->orWhere('project_manager','like','%、'.$user->name)->select(DB::raw('count(*) as num,project_manager,audit_progress'))->groupBy('project_manager','audit_progress')->get();
      $data2=DB::table('rreturns')->where('project_manager',$user->name)->orWhere('project_manager','like',$user->name.'、%')->orWhere('project_manager','like','%、'.$user->name)->select(DB::raw('count(DISTINCT project_number) as project_num'))->first();
      //dd($data2);
      if($data->isEmpty())
        $text="没有您的数据，请核实情况！";
      else{
      foreach($data as $value)
      {
        if(in_array($value->audit_progress, $data_tem))
          $data_array[$value->audit_progress]+=$value->num;
        else
          $data_array[$value->audit_progress]=$value->num;
        $data_tem[]=$value->audit_progress;
      }
      //dd($data_array);
      $project_manager=$user->name;
      $project_num=$data2->project_num;
      $nosend=isset($data_array['未送审'])?$data_array['未送审']:0;
      $sending=isset($data_array['审计中'])?$data_array['审计中']:0;
      $sended=isset($data_array['被退回'])?$data_array['被退回']:0;
      $finish=isset($data_array['已出报告'])?$data_array['已出报告']:0;
      $text=$project_manager.',你好！您的决算审计情况如下：你总共有'.$project_num.'个项目：未送审：'.$nosend.'个，被退回：'.$sended.'个，审计中：'.$sending.'个，已出报告：'.$finish.'个。具体请上平台查阅。';
      //dd($text);
      }
    }
    elseif($eventkey=='V1_REFUND')
    {
      $data_tem['project_num']=0;
      $data_tem['construction_should_refund_total']=0;
      $data_tem['thing_refund_total']=0;
      $data_tem['cash_refund_total']=0;
      $data_tem['direct_yes_total']=0;
      $data_tem['direct_no_total']=0;
      $data_tem['unrefund_cost_total']=0;
      $datas=DB::table('refunds')->where('project_manager',$user->name)->orWhere('project_manager','like',$user->name.'、%')->orWhere('project_manager','like','%、'.$user->name)->select(DB::raw('count(DISTINCT kkk) as project_num,sum(construction_should_refund) as construction_should_refund_total,sum(thing_refund) as thing_refund_total,sum(cash_refund) as cash_refund_total,sum(direct_yes) as direct_yes_total,sum(direct_no) as direct_no_total,sum(unrefund_cost) as unrefund_cost_total,project_manager'))->groupBy('project_manager')->get();
      if($datas->isEmpty())
        $text="没有您的数据，请核实情况！";
      else {
      foreach($datas as $value)
      {

          $data_tem['project_num']+=$value->project_num;
          $data_tem['construction_should_refund_total']+=$value->construction_should_refund_total;
          $data_tem['thing_refund_total']+=$value->thing_refund_total;
          $data_tem['cash_refund_total']+=$value->cash_refund_total;
          $data_tem['direct_yes_total']+=$value->direct_yes_total;
          $data_tem['direct_no_total']+=$value->direct_no_total;
          $data_tem['unrefund_cost_total']+=$value->unrefund_cost_total;
          $text=$user->name.',你好！您的物资退库情况如下：你总共有'.$data_tem['project_num'].'项目：应退库：'.$data_tem['construction_should_refund_total'].'元，实物已退库：'.$data_tem['thing_refund_total'].'元，现金已退库：'.$data_tem['cash_refund_total'].'元，直接用于其他工程（有登记）：'.$data_tem['direct_yes_total'].'元，直接用于其他工程（未登记）：'.$data_tem['direct_no_total'].'元，未退库：'.$data_tem['unrefund_cost_total'].'元。具体请上平台查阅。';
      }
      //dd($text);
      }
    }

  return $text;
  }

//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxfcaefa0fe4c98249&redirect_uri=https%3a%2f%2fwww.cmccgjb.cn%2fweixin%2fweixinlogin&response_type=code&scope=snsapi_base&state=123#wechat_redirect
  public function weixinlogin()
  {

      $userinfo = session('wechat.oauth_user.default');

      $openid=$userinfo->id;

      $user=User::where('openid',$openid)->first();
      //dd($user);
      if($user&&$user->activated)
      {
        Auth::login($user);
        session()->flash('success', Auth::user()->name.',欢迎回来！您的角色是'.Auth::user()->getRoleNames()->first());
        $loginrecord=new Loginrecord;
        $loginrecord->name=Auth::user()->name;
        $loginrecord->save();
        return redirect()->route('users.show',$user->id);
      }
      else
      {
        session()->flash('warning', '你的账号未激活或者不存在对应的项目经理，请核实后再登陆！');
        return redirect('/');
      }

  }

  // public function weixinloginbefore()
  // {
  //   Header("Location: http://www.cmccgjb.cn/weixinlogin");
  // }
}
