<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class SessionsController extends Controller
{
    public function create()
  {
    if (!Auth::check())
    return view('sessions.create');
    else
    return view('users.home');
    }



  public function store(Request $request)
   {
      $credentials = $this->validate($request, [
          'email' => 'required|email|max:255',
          'password' => 'required'
      ]);

      //dd($credentials);
      if (Auth::attempt($credentials,$request->has('remember'))) {
          session()->flash('success', '欢迎回来！');
          return redirect()->route('users.show', [Auth::user()]);
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
