<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loginrecord;
use App\Models\Trace;
use Illuminate\Support\Facades\DB;
use App\Models\User;

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
      $time=date('Y-m-d');
      $month=date('m');//获取带0的目前月份
      $currentyear_no0=date('o');//获取不带0的目前年份
      $currentmonth_no0=date('n');//获取不带0的目前月份
      $users=DB::table('users')->select('name')->groupBy('name')->get();
      foreach($users as $value)
      {
        $user_tem[]=$value->name;
      }
      $click_yearandmonth=$this->request->query('yearandmonth')?$this->request->query('yearandmonth'):$currentyear_no0.'-'.$currentmonth_no0;
      if($this->request->query())
      {
        $yearandmonth_array=explode('-',$this->request->query('yearandmonth'));
        $m=$yearandmonth_array[1];
        $y=$yearandmonth_array[0];
        $monthday = cal_days_in_month(CAL_GREGORIAN,$m,$y);
        //dd($monthday);
        //dd($y.'-'.$m.'-'.$monthday);
        $end=date('Y-m-d',strtotime("+1 day",strtotime($y.'-'.$m.'-'.$monthday)));
        //$end=date('Y-m-d',strtotime());
      }
      else{
        $y=$currentyear_no0;
        $m=$currentmonth_no0;
        $end=date('Y-'.$month.'-t',strtotime("+1 day",strtotime($time)));
      }
      //dd($end);

      //获取目前时间
      $start=date('Y-m-d',strtotime($y.'-'.$m.'-1'));//获取指定月份的第一天
      //dd($start);
      //获取指定月份的最后一天


      $datas0=DB::table('loginrecords')->select(DB::raw('DATE_FORMAT(min(created_at),"%Y-%c") as mintime,DATE_FORMAT(max(created_at),"%Y-%c") as maxtime'))->first();
      $diff=date_diff(date_create($datas0->maxtime),date_create($datas0->mintime));
//dd($diff);
      $datas0=$diff->m+1;
      $datas0=$this->handledatas0($datas0,$currentyear_no0,$currentmonth_no0);
      //dd($tem_date0);
      $datas3=Loginrecord::whereBetween('created_at',[$start,$end])->orderBy('created_at','asc')->get();
      foreach($datas3 as $data3)
        $datas3_array[$data3->name]['loginrecords'][]=date('Y-m-d H:i:s',strtotime($data3->created_at));

      //dd($datas3_array);
      $datas1=DB::table('loginrecords')->whereBetween('created_at',[$start,$end])->select(DB::raw('count(*) as loginnum,min(created_at) as mintime,max(created_at) as maxtime,name'))->orderBy('loginnum','desc')->groupBy('name')->get();

      $datas1=$this->handleDatas1OrDatas4($datas1,$datas3_array,$user_tem);
      //dd($datas1);
      //dd($datas1_supplement);

      $datas2=DB::table('loginrecords')->whereBetween('created_at',[$start,$end])->select(DB::raw('count(*) as loginnums,DATE_FORMAT(created_at,"%Y-%c-%e") as ymd'))->groupBy('ymd')->get();
      $datas2=$this->handleDatas2OrDatas5($datas2,$month,$start,$time,$y,$m);
      //dd($datas2);
      //$datas4=DB::table('traces')->whereBetween('created_at',[$start,$end])->orderBy('created_at','desc')->get();
      $datas4=DB::table('traces')->whereBetween('created_at',[$start,$end])->select(DB::raw('count(*) as actionnum,name'))->orderBy('actionnum','desc')->groupBy('name')->get();
      //dd($datas4);
      $datas6=Trace::whereBetween('created_at',[$start,$end])->orderBy('created_at','asc')->get();
      foreach($datas6 as $data6)
        $datas6_array[$data6->name]['actionrecords'][]=$data6->content;
      if(!isset($datas6_array))
        $datas6_array=[];
      //dd($datas6_array);
      $datas4=$this->handleDatas1OrDatas4($datas4,$datas6_array,$user_tem);
      $datas5=DB::table('traces')->whereBetween('created_at',[$start,$end])->select(DB::raw('count(*) as actionnums,DATE_FORMAT(created_at,"%Y-%c-%e") as ymd'))->groupBy('ymd')->get();
      $datas5=$this->handleDatas2OrDatas5($datas5,$month,$start,$time,$y,$m);
      //dd($datas5);
      //$datas1_supplements=$this->handledatas1($datas1);
      //dd($click_yearandmonth);
      return view('baseinformation.loginaction',['current_url'=>$this->request->url(),'click_yearandmonth'=>$click_yearandmonth,'datas0'=>$datas0,'datas1'=>$datas1,'datas2'=>$datas2,'datas3_array'=>$datas3_array,'datas4'=>$datas4,'datas5'=>$datas5]);

    }

    protected function handleDatas1OrDatas4($datas1,$datas3_array,$user_tem)
    {
      $data1_tem=[];
      $datas1_array['datas']=[];
      if(!$datas1==[])
      {
        foreach($datas1 as $value)
          {
            $data1_tem[]=$value->name;
            $datas1_array['datas'][$value->name]=$value;
          }

    //  dd(array_diff($user_tem,$data1_tem));
        $datas1_array['datas_supplements']=array_diff($user_tem,$data1_tem);
        $datas1_array['datas']=array_merge_recursive($datas1_array['datas'],$datas3_array);
      }
      else
      {
        $datas1_array['datas_supplements']=$user_tem;
        $datas1_array['datas']=[];
      }
        //dd($datas1_array);
    return $datas1_array;
    }



//返回登录统计页第一个统计图的数据源
    protected function handleDatas2OrDatas5($datas2,$month,$start,$time,$y,$m)
    {

      $diff=date_diff(date_create($start),date_create($time));

      $tem_ymd=[];
      foreach($datas2 as $date)
      {
        $array_ymd=explode('-',$date->ymd);
        //dd($array_ymd[2]);
        $date->day=$array_ymd[2];
        $date->month=$array_ymd[1];
        $date->year=$array_ymd[0];
        //dd($date->day);
          $tem_ymd[]=$date->ymd;
        //dd(gettype($date->ymd));
      }
    //  dd($tem);
      for ($x=1; $x<$diff->d+1; $x++) {
          if(!in_array($y."-".$m."-".$x,$tem_ymd))
        {
          $tem_date2['ymd']=$y."-".$m."-".$x;
          $tem_date2['loginnums']=0;
          $tem_date2['day']=$x;
          $tem_date2['month']=$m;
          $tem_date2['year']=$y;
          $datas2->push((object)$tem_date2);
        }

      }
      //dd($datas2);
      $datas_2=[];
      $datas_2['x']=[];
      $datas_2['y']=[];
      $datas_2['title']=$y.'年'.$m.'月';;
      $datas2 = $datas2->sortBy(function ($value, $key)use($datas_2) {
        return $value->day;
    });
    //dd($datas2);
    foreach($datas2 as $date)
    {
      $datas_2['x'][]=$date->day;
      $datas_2['y'][]=isset($date->loginnums)?$date->loginnums:$date->actionnums;
    //  $datas_2['title']=$date->year.'年'.$date->month.'月';
    }
    $datas_2['x']=json_encode($datas_2['x']);
    $datas_2['y']=json_encode($datas_2['y']);
        //dd($datas_2);
        return $datas_2;
    }

//返回select的年月数据源
    protected function handledatas0($datas0,$y,$m)
    {
      for ($x=1; $x<=$datas0; $x++) {
        $month_change=$x+$m-$datas0;
        if($month_change<=12)
          //$x_mod=$x;
          $tem_date0[]=$y."-".$month_change;
        elseif($month_change>12)
        {
          $x_mod=mod($month_change,12);
          $x_floor=floor($month_change/12);
          $tem_date0[]=($y+$x_floor)."-".$x_mod;
        }
      }
      return $tem_date0;
    }
}
