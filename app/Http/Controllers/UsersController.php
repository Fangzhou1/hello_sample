<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Mail;
class UsersController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth', [
          'except' => ['create', 'store','destroy']
      ]);
      $this->middleware('guest', [
        'only' => ['create','store']
      ]);
  }

  public function index()
    {
        $page=10;
        $users = User::paginate($page);
        return view('users.index', compact('users','page'));
    }

  public function create()
 {
     return view('users.create');
 }

 public function show(User $user)
{
    return view('users.show', compact('user'));
}

 public function store(Request $request)
 {
   $this->validate($request, [
      'name' => 'required|max:50',
      'email' => 'required|email|unique:users|max:255',
      'password' => 'required|confirmed|min:6'
  ]);

  $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
  $this->sendEmailConfirmationTo($user);
  session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
  return redirect('/');
}

  public function edit(User $user)
   {


       $this->authorize('update', $user);
       return view('users.edit', compact('user'));
   }

   public function update(User $user, Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6',
            'introduction'=>'max:80',
        ]);
        $this->authorize('update', $user);
        //文件头像上传
        $extension = strtolower($request->file('avatar')->getClientOriginalExtension()) ?: 'png';
        $allowed_ext = ["png", "jpg", "gif", 'jpeg'];
        if (!in_array($extension, $allowed_ext)) {
              session()->flash('danger', '上传文件不是图片，请重新上传');
            return redirect()->back();;
        }
        $path = $request->file('avatar')->store('avatars'.'/'.date("Ym", time()).'/'.date("d", time()));

        $data = [];
        $data['avatar'] = $path;
        $data['name'] = $request->name;
        $data['introduction'] =$request->introduction;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $user->id);
    }

    public function destroy(User $user)
      {
          $this->authorize('destroy', $user);
          $user->delete();
          session()->flash('success', '成功删除用户！');
          return back();
      }

      protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = '13971192686@139.com';
        $name = 'fangzhou';
        $to = $user->email;
        $subject = "感谢注册 工程部审计 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }

    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', compact('user'));
    }
}
