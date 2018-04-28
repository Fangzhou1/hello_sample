<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loginrecord;
use Illuminate\Support\Facades\DB;

class BaseinformationController extends Controller
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        //$this->middleware('check');
        $this->request=$request;
    }

    public function loginaction()
    {
      $month=date('m');
      $m=date('n');
      //dd($month);
      $time=date('Y-m-d');//获取目前时间
      $start=date('Y-'.$month.'-01',strtotime($time));//获取指定月份的第一天
      //dd($start);
      $diff=date_diff(date_create($start),date_create($time));
      $end=date('Y-m-t',strtotime($time)); //获取指定月份的最后一天
      //dd($diff->d);

      $datas1=DB::table('loginrecords')->select(DB::raw('count(*) as loginnum,name'))->orderBy('loginnum','desc')->groupBy('name')->get();
      $datas2=DB::table('loginrecords')->whereBetween('created_at',[$start,$end])->select(DB::raw('count(*) as loginnums,DATE_FORMAT(created_at,"%c-%e") as md'))->groupBy('md')->get();
      //dd($datas2);
      foreach($datas2 as $date)
      {
        $tem_md[]=$date->md;
        //dd(gettype($date->md));
      }
    //  dd($tem);
      for ($x=1; $x<=$diff->d+1; $x++) {
        if(!in_array($m."-".$x,$tem_md))
        {
          $tem_date2['md']=$m."-".$x;
          $tem_date2['loginnums']=0;

          $datas2->push((object)$tem_date2);
        }
      }
      //dd($datas2);
      $sorted = $datas2->sortBy(function ($value, $key) {
        return $value->md;
    });

        dd($sorted->values()->all());
      return view('baseinformation.loginaction',['current_url'=>$this->request->url(),'datas1'=>$datas1]);

    }
}
