<?php

namespace App\Listeners;

use App\Events\ModifyDates;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Settlement;
use App\Models\Rreturn;
use App\Models\Refund;
use App\Models\Refunddetail;
use Illuminate\Support\Facades\DB;
use App\Models\Trace;
use Carbon\Carbon;
use Auth;


class StorageTrace
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ModifyDates  $event
     * @return void
     */
    public function handle(ModifyDates $event)
    {
      $mes2="";
      $trace = new Trace;
      $trace->type=$event->data['type'];
      $trace->created_at=Carbon::now();
      $trace->year=$trace->created_at->year;
      $trace->month=$trace->created_at->month;
      $trace->content='';
      $audit_progress_arr=['未送审','审计中','被退回'];
      $ret0=Settlement::where("project_number",$event->data['project_number'])->get();
      $ret=Settlement::where("project_number",$event->data['project_number'])->whereIn("audit_progress",$audit_progress_arr)->get();
      $rreturn=Rreturn::where('project_number',$event->data['project_number'])->first();
      if($trace->type=='结算')
        {
        $trace->content=$event->data['name']."于".$trace->created_at.$event->mes."结算表里订单编号为".$event->data['order_number']."的订单。";
          if($rreturn)
          {
              if($ret->isEmpty())
                  {
                    if(!$ret0->isEmpty()){
                        if($rreturn->audit_progress!='已出报告'){
                          $rreturn->is_canaudit='是';
                          $mes2="并且项目编号为".$event->data['project_number']."的项目结算已全部完成，可以开始决算审计了！";
                          $rreturn->save();
                        }
                    }
                    elseif($rreturn->is_needsaudit=='是') {
                      $mes2="项目编号为".$event->data['project_number']."的项目没有结算审计订单，请录入结算审计订单！";
                    }
                    elseif($rreturn->is_needsaudit=='否'&&$rreturn->is_canaudit=='否') {
                      $rreturn->is_canaudit='是';
                    }

                  }
              elseif($rreturn->is_needsaudit=='是')
              {
                  if($rreturn->is_canaudit=='是')
                      {
                      $rreturn->is_canaudit='否';
                      $mes2="由于项目编号为".$event->data['project_number']."的项目结算审计未全部完成，此项目决算审计状态回退至不具备条件！";
                      }
                  if(in_array($rreturn->audit_progress, ['审计中','被退回','已出报告'])){
                      $rreturn->audit_progress='未送审';
                      $mes2=$mes2."由于项目编号为".$event->data['project_number']."的项目结算审计未全部完成，决算审计进度退回至未送审状态！";
                      }
                      $rreturn->save();
              }

              elseif($rreturn->is_needsaudit=='否')
              {
                  $rreturn->is_canaudit='是';
                  $mes2="由于项目编号为".$event->data['project_number']."的项目不需要结算审计，可以将此项目中结算审计的订单删除。并且项目可直接进入决算审计。";

              }
              $trace->content=$trace->content.$mes2;


          }
          else

              if($ret->isEmpty())
              {
                $mes2="并且项目编号为".$event->data['project_number']."的项目结算审计已全部完成，但是决算表中没有录入项目编号为的项目,请立即录入！";
                $trace->content=$trace->content.$mes2;
              }
        }
      elseif($trace->type=='决算')
      {
        $trace->content=$event->data['name']."于".$trace->created_at.$event->mes."决算表里项目编号为".$event->data['project_number']."的条目。";
          if($rreturn)
          {
              if($ret->isEmpty())
              {
                  if(!$ret0->isEmpty()){
                      if($rreturn->audit_progress!='已出报告'){
                        $rreturn->is_canaudit='是';
                        $mes2="并且项目编号为".$event->data['project_number']."的项目结算已全部完成，可以开始决算审计了！";
                        $rreturn->save();
                      }
                  }
                  elseif($rreturn->is_needsaudit=='是') {
                    $mes2="项目编号为".$event->data['project_number']."的项目没有结算审计订单，请录入结算审计订单！";
                  }
                  elseif($rreturn->is_needsaudit=='否'&&$rreturn->is_canaudit=='否') {
                    $rreturn->is_canaudit='是';
                  }

              }
              elseif($rreturn->is_needsaudit=='是')
              {
                  if($rreturn->is_canaudit=='是'){
                      $rreturn->is_canaudit='否';
                      $mes2="由于项目编号为".$event->data['project_number']."的项目结算审计未全部完成，此项目决算审计状态回退至不具备条件！";
                  }
                  if(in_array($rreturn->audit_progress, ['审计中','被退回','已出报告'])){
                      $rreturn->audit_progress='未送审';
                      $mes2=$mes2."由于项目编号为".$event->data['project_number']."的项目结算审计未全部完成，此项目决算审计进度退回至未送审状态！";
                  }
                  $rreturn->save();

              }

              elseif($rreturn->is_needsaudit=='否')
              {

                    $rreturn->is_canaudit='是';
                    $mes2="由于项目编号为".$event->data['project_number']."的项目不需要结算审计，可以将此项目中结算审计的订单删除。并且项目可直接进入决算审计。";



              }
              $trace->content=$trace->content.$mes2;

          }
          else

            if($ret->isEmpty())
            {
                $mes2="项目编号为".$event->data['project_number']."的项目结算审计已全部完成，但是决算表中已删除了项目编号为".$event->data['project_number']."的项目,请立即录入或采取其他措施！";
                $trace->content=$trace->content.$mes2;
            }

      }
      elseif($trace->type=='物资')
      {
        $mes2=$event->data['name']."于".$trace->created_at.$event->mes."物资表里项目编号为".$event->data['project_number']."且审计文号为".$event->data['audit_document_number']."的条目。";
        $audit_document_number=$event->data['audit_document_number'];
        $project_number=$event->data['project_number'];
        $refunddetails = DB::table('refunddetails')->where('audit_document_number',$audit_document_number)->where('project_number',$project_number)->select(DB::raw('sum(subtraction_cost) as construction_should_refund_total,sum(refund_cost) as thing_refund_total,sum(cash_refund) as cash_refund_total,sum(unrefund_cost) as unrefund_cost_total'))->first();
        //dd($refunddetails);
        $refunds=Refund::where('audit_document_number',$audit_document_number)->where('project_number',$project_number)->select('construction_should_refund','thing_refund','cash_refund','unrefund_cost')->first();
        //dd($refunds);
        if(round($refunddetails->construction_should_refund_total)!==round($refunds->construction_should_refund)||round($refunddetails->thing_refund_total)!==round($refunds->thing_refund)||round($refunddetails->cash_refund_total)!==round($refunds->thing_refund)||round($refunddetails->cash_refund)!==round($refunds->unrefund_cost))
          $mes2.="但是退库物资和物资详情的数据不一致，请核实后修改。";
        $trace->content=$trace->content.$mes2;

      }
      elseif($trace->type=='物资详情')
      {
        $mes2=$event->data['name']."于".$trace->created_at."为".$event->data['project_number']."的项目且审计文号为".$event->data['audit_document_number']."的退库条目下".$event->mes."物资名称为".$event->data['material_name']."的退库详情。";
        //dd($event->data);
        $audit_document_number=$event->data['audit_document_number'];
        $project_number=$event->data['project_number'];
        $refunddetails = DB::table('refunddetails')->where('audit_document_number',$audit_document_number)->where('project_number',$project_number)->select(DB::raw('sum(subtraction_cost) as construction_should_refund_total,sum(refund_cost) as thing_refund_total,sum(cash_refund) as cash_refund_total,sum(unrefund_cost) as unrefund_cost_total'))->first();
        //dd($refunddetails);
        $refunds=Refund::where('audit_document_number',$audit_document_number)->where('project_number',$project_number)->select('construction_should_refund','thing_refund','cash_refund','unrefund_cost')->first();
        //dd($refunds);
        if(round($refunddetails->construction_should_refund_total)!==round($refunds->construction_should_refund)||round($refunddetails->thing_refund_total)!==round($refunds->thing_refund)||round($refunddetails->cash_refund_total)!==round($refunds->thing_refund)||round($refunddetails->cash_refund)!==round($refunds->unrefund_cost))
          $mes2.="但是退库物资和物资详情的数据不一致，请核实后修改。";
        $trace->content=$trace->content.$mes2;
      }
      $trace->name=Auth::user()->name;
      $trace->save();
      return $mes2;

    }
}
