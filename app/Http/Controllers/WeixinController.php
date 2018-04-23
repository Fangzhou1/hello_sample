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

  public function sendweixin(Request $request){
    $emailinfo=$request->query();
    dd($emailinfo);
    //dd('1');
    $users = $this->officialAccount->user->list();
    //dd($users);
    if($type='结算审计进度'){

    }
    elseif($type='决算审计进度')
    {

    }
    elseif($type='物资退库'){


    }
}
}
