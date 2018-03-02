<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\Settlement;
use App\Handlers\ExcelUploadHandler;



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



}
