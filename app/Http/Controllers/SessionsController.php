<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loginrecord;
use Auth;
class SessionsController extends Controller
{
  public function __construct()
  {
      $this->middleware('guest', [
        'only' => ['create','store']
      ]);

      $this->middleware('auth', [
        'only' => ['destroy']
      ]);


  }
    public function create()
  {

    return view('sessions.create');

    }



  public function store(Request $request)
   {
      $credentials = $this->validate($request, [
          'email' => 'required|email|max:255',
          'password' => 'required'
      ]);

      //dd($credentials);
      if (Auth::attempt($credentials,$request->has('remember'))) {

        if(Auth::user()->activated) {
              $loginrecord=new Loginrecord;
              $loginrecord->name=Auth::user()->name;
              $loginrecord->save();
               session()->flash('success', Auth::user()->name.',欢迎回来！您的角色是'.Auth::user()->getRoleNames()->first());
               return redirect()->intended(route('users.show', [Auth::user()]));
           } else {
               Auth::logout();
               session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
               return redirect('/');
           }
      }
      else{
        session()->flash('danger', '密码或用户名不正确');
         return redirect()->back();
   }

}
  public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}
