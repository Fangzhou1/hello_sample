<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
  protected $request;
  public function __construct(Request $request)
  {
      $this->middleware('auth');
      $this->request=$request;


  }

  public function index()
    {
      $roles=Role::get();
      return view('Roles.index',['current_url'=>$this->request->url(),'roles'=>$roles]);
    }

    public function rowupdate(Role $role)
    {
      //dd($this->request->all());
      Role::where('id',$role->id)->update($this->request->except('_token'));
      session()->flash('success', '恭喜你，更新数据成功！');
      return redirect()->back();
    }

    public function destroy(Role $role)
    {
      $role->delete();
      session()->flash('success', '恭喜你，删除成功！');
      return redirect()->back();
    }


    public function create()

     {
      return view('Roles.create');
     }


     public function store()
     {
       $datarequest=$this->request->except('_token');
       $role=Role::create($datarequest);
       session()->flash('success', '恭喜你，添加数据成功！');
       return redirect()->route('roles.index');
     }
}
