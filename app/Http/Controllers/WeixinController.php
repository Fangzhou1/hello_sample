<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\Voice;
use EasyWeChat;

class WeixinController extends Controller
{
  protected $officialAccount;
  public function __construct(Request $request)
  {
      // $this->middleware('auth');
      // $this->middleware('check');
      // $this->request=$request;
     $this->officialAccount = EasyWeChat::officialAccount();
  }
  public function index(){
  //  file_put_contents("test.txt","Hello World. Testing!");


    $this->officialAccount->server->push(function ($message) {
      if($message['MsgType']=='event'&&$message['Event']=='subscribe')
        $msg='你好，谢谢你关注工程审计公众号';
      elseif($message['MsgType']=='text'&&$message['Content']=="进度")
        $msg = new Text('您好！蔡琪祺');
      return $msg;
});
     return $this->officialAccount->server->serve();

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
}
