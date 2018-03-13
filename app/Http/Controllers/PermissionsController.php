<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{

  protected $request;
  public function __construct(Request $request)
  {
      $this->middleware('auth');
      $this->request=$request;


  }

  public function index()
    {
      $permissions=Permission::get();

        // $page=10;
        // $settlements['title'] = Settlement::first();
        // $settlements['data'] = Settlement::where('order_number','<>','订单编号')->paginate($page);
        //
        // $tracesdata=Trace::where('type','结算')->orderBy('created_at','desc')->get();
        // if($tracesdata->isEmpty()){
        //   return view('settlements.index',['current_url'=>$this->request->url(),'settlements'=>$settlements,'traces'=>[]]);
        // }
        // //dd($traces);
        // //dd($settlements);
        // foreach ($tracesdata as $value) {
        //   $traces[$value->year.'年'.$value->month.'月'][]=$value;
        // }

        //dd($traces);
        return view('permissions.index',['current_url'=>$this->request->url(),'permissions'=>$permissions]);
    }

    public function create()

   {
    dd('1');   //return view('users.create');
   }
}
