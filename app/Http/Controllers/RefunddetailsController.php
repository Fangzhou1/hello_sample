<?php

namespace App\Http\Controllers;
use App\Handlers\ExcelUploadHandler;
use Illuminate\Support\Facades\DB;
use App\Models\Refunddetail;
use App\Models\Refund;
use Illuminate\Http\Request;
use App\Events\ModifyDates;
use App\Events\ChangeOrder;
use Auth;

class RefunddetailsController extends Controller
{
  protected $request;
  public function __construct(Request $request)
  {
      $this->middleware('auth');
      $this->middleware('check');
      $this->request=$request;
  }

  public function importrefunddetailsbymanager(Refunddetail $refunddetail)
    {
      //Settlement::truncate();
      $kkk=$this->request->input('kkk');
      $file=$this->request->file('excel_d_bym');
      $upload=new ExcelUploadHandler;
      $data=$upload->save($file);

      //dd($data);
      if($data=='error1')
        return redirect()->back();
      elseif($data=='error2')
        return redirect()->back();
      unset($data[0]);
      foreach($data as &$value)
      {
        //dd($value['project_number'].'/'.$value['audit_document_number']);
        if($value['project_number'].'/'.$value['audit_document_number']!==$kkk){
          session()->flash('danger', '上传失败！上传文件的项目编号或审计文号与当前物资下的不一致，请修改excel表格后重新上传！');
          return redirect()->back();
        }
        $value['kkk2']=$kkk;
      }

      //dd($data);
      DB::table('refunddetails')->where('kkk2', $kkk)->delete();
      DB::table('refunddetails')->insert($data);
      session()->flash('success', '恭喜你，导入数据成功！');

      return redirect()->back();
    }

  public function edit(Refunddetail $refunddetail)
    {
        // $page=10;
        // $settlements = Settlement::paginate($page);
      //dd($refunddetail);

        return view('refunddetails.edit',['current_url'=>$this->request->url(),'refunddetail'=>$refunddetail]);
    }

    public function update(Refunddetail $refunddetail)
      {

          // $page=10;
          // $settlements = Settlement::paginate($page);

          $datas=$this->request->except(['_token','_method']);
            //dd($data);
          $refunddetail->update($datas);


          $data['name']=Auth::user()->name;
          $data['project_number']=$datas['project_number'];
          $data['audit_document_number']=$datas['audit_document_number'];
          $data['material_name']=$datas['material_name'];
          $data['type']='物资详情';
          $mes='更新了';
          //dd($data);
          $mes2=event(new ModifyDates($data,$mes));
          broadcast(new ChangeOrder(Auth::user(),"项目编号为".$datas['project_number']."且审计文号为".$datas['audit_document_number']."且物料名称为".$datas['material_name']."的退库物资详情","刚刚更新了",$mes2));
          session()->flash('success', '恭喜你，更新数据成功！');
          return redirect()->back();
      }

      public function create()
        {

          return view('refunddetails.create',['current_url'=>$this->request->url()]);
        }

      public function store()
        {
          //dd(route('refunds.refundsdetail',['refunddetails'=>$refund->refunddetails]));
          $query=$this->request->post('project_number').'/'.$this->request->post('audit_document_number');
          $refund=Refund::where('kkk',$query)->first();
          //dd($refund);
        //  dd(route('refunds.refundsdetail',['refund'=>$refund]));
          $refunddetail=$refund->refunddetails()->create($this->request->post());
          //dd($refunddetail);

          $data['name']=Auth::user()->name;
          $data['project_number']=$refund->project_number;
          $data['audit_document_number']=$refund->audit_document_number;
          $data['material_name']=$refunddetail->material_name;
          $data['type']='物资详情';
          $mes='新增了';
          //dd($data);
          $mes2=event(new ModifyDates($data,$mes));
          broadcast(new ChangeOrder(Auth::user(),"项目编号为".$refund->project_number."且审计文号为".$refund->audit_document_number."且物料名称为".$refunddetail->material_name."的退库物资详情","刚刚新增了",$mes2));
          session()->flash('success', '恭喜你，新增数据成功！');
          return redirect()->route('refunds.refundsdetail',['refund'=>$refund]);

        }

        public function destroy(Refunddetail $refunddetail)
        {
          //dd($refunddetail);
          $refunddetailadn=$refunddetail->audit_document_number;
          $refunddetailpn=$refunddetail->project_number;
          $refunddetailmn=$refunddetail->material_name;
          $refunddetail->delete();
          $data['name']=Auth::user()->name;
          $data['audit_document_number']=$refunddetailadn;
          $data['project_number']=$refunddetailpn;
          $data['material_name']=$refunddetailmn;
          $data['type']='物资详情';
          $mes='删除了';
          $mes2=event(new ModifyDates($data,$mes));
          broadcast(new ChangeOrder(Auth::user(),"项目编号为".$refunddetailpn."且审计文号为".$refunddetailadn."且物料名称为".$refunddetailmn."的退库物资详情","刚刚删除了",$mes2));
          session()->flash('success', '恭喜你，删除成功！');
          return redirect()->back();

        }


}
