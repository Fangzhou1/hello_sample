<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Mail;
use App\Handlers\ImageUploadHandler;
use Spatie\Permission\Models\Role;
use Auth;


class UsersController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth', [
          'except' => ['create', 'store','confirmEmail']
      ]);
      $this->middleware('guest', [
        'only' => ['create','store','confirmEmail']
      ]);
      $this->middleware('check',['except' => ['create', 'store','confirmEmail']]);
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
      'name' => 'required|unique:users|max:50',
      'email' => 'required|email|unique:users|max:255',
      'password' => 'required|confirmed|min:6',
      'captcha' => 'required|captcha',
  ],['captcha.required' => '验证码不能为空',
     'captcha.captcha' => '请输入正确的验证码',
        ]);

    $data=[
              'name' => $request->name,
              'email' => $request->email,
              'password' => bcrypt($request->password),
          ];
      if($request->name=='fangzhou')
      {
        $data['activated']=1;
        $user = User::create($data);
        $user->assignRole('站长');
        Auth::login();
        session()->flash('success', '欢迎您，站长！');
        return redirect('/');
      }

  $user = User::create($data);

  $this->sendEmailConfirmationTo($user);
  session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
  return redirect('/');
}

  public function edit(User $user)
   {


       $this->authorize('update', $user);
       return view('users.edit', compact('user'));
   }

   public function update(User $user, Request $request,ImageUploadHandler $uploader)
    {

        $messages = [
      'avatar.dimensions' => '尺寸不能在200px*200px以下'
        ];
         $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6',
            'introduction'=>'max:80',
            'avatar' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=200,min_height=200',
        ],$messages);


        $this->authorize('update', $user);
        $data = [];
        if($request->file('avatar'))
        {
        //文件头像上传
          $path=$uploader->save($request->file('avatar'),'avatars',362);
          $data['avatar'] = $path['path'];
        }
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
        $from = '253251551@qq.com';
        $name = 'sample';
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
        return redirect()->route('users.show', $user->id);
    }

      public function usersactionindex(Request $request)
     {
       $page=10;
       $users = User::paginate($page);
       return view('users.usersactionindex', ['users'=>$users,'page'=>$page,'current_url'=>$request->url()]);
     }

     public function rolestouserpage(User $user,Request $request)
    {
      $roles=Role::all();
      return view('users.rolestouserpage', ['user'=>$user,'roles'=>$roles,'current_url'=>$request->url()]);

    }

    public function rolestouser(User $user,Request $request)
   {

     $user->syncRoles($request->input('role'));
     session()->flash('success', '恭喜你，角色分配成功！');
     $page=10;
     $users = User::paginate($page);
     return redirect()->route('users.usersactionindex');

   }

}
