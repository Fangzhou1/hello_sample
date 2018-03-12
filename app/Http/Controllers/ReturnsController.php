<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Rreturn;
use App\Handlers\ExcelUploadHandler;

class RreturnsController extends Controller
{
  protected $request;
  public function __construct(Request $request)
  {
      $this->middleware('auth');
      $this->request=$request;
  }

  public function importpage()
    {
        // $page=10;
        // $rreturns = Rreturn::paginate($page);

        return view('rreturns.importpage',['current_url'=>$this->request->url()]);
    }

    public function import()
      {
          Rreturn::truncate();
          //dd('已经清空');
          $file=$this->request->file('excel');
          $upload=new ExcelUploadHandler;
          $data=$upload->save($file);
          //dd($data);
          DB::table('rreturns')->insert($data);
          session()->flash('success', '恭喜你，导入数据成功！');
          //broadcast(new ChangeOrder(Auth::user(),$rreturn));
          return redirect()->back();
      }

      public function index()
        {
            $page=10;
            $rreturns['title'] = Rreturn::first();
            $rreturns['data'] = Rreturn::where('project_number','<>','项目编号')->paginate($page);

            // $tracesdata=Trace::where('type','决算')->orderBy('created_at','desc')->get();
            // if($tracesdata->isEmpty()){
            //   return view('settlements.index',['current_url'=>$this->request->url(),'rreturns'=>$rreturns,'traces'=>[]]);
            // }

            // foreach ($tracesdata as $value) {
            //   $traces[$value->year.'年'.$value->month.'月'][]=$value;
            // }

            //dd($traces);
            return view('rreturns.index',['current_url'=>$this->request->url(),'rreturns'=>$rreturns]);//'traces'=>$traces
        }

        public function rowupdate(Rreturn $rreturn)
        {
          //dd($this->request->all());
          Rreturn::where('id',$rreturn->id)->update($this->request->except('_token'));
          session()->flash('success', '恭喜你，更新数据成功！');
          $data['name']=Auth::user()->name;
          $data['project_number']=$rreturn->project_number;
          $data['type']='决算';
          $mes='修改了';
          event(new ModifyDates($data,$mes));
          broadcast(new ChangeOrder(Auth::user(),$rreturn->project_number,"刚刚修改了项目编号为"));
          return redirect()->back();
        }

        public function destroy(Rreturn $rreturn)
        {
          //dd($rreturn->id);
          $rreturnodn=$rreturn->project_number;
          $rreturn->delete();
          $data['name']=Auth::user()->name;
          $data['project_number']=$rreturnodn;
          $data['type']='决算';
          $mes='删除了';
          event(new ModifyDates($data,$mes));
          broadcast(new ChangeOrder(Auth::user(),$rreturnodn,"刚刚删除了项目编号为"));
          session()->flash('success', '恭喜你，删除成功！');
          return redirect()->back();

        }

}
