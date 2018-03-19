<?php

namespace App\Listeners;

use App\Events\ModifyDates;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Settlement;
use App\Models\Rreturn;
use App\Models\Trace;
use Carbon\Carbon;


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
                  if(!$ret0->isEmpty())
                  $mes2="由于项目编号为".$event->data['project_number']."的项目不需要结算审计，可以将此项目中结算审计的订单删除。";

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
                  if(!$ret0->isEmpty())
                  $mes2="由于项目编号为".$event->data['project_number']."的项目不需要结算审计，可以将此项目中结算审计的订单删除。";

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

      $trace->save();
      return $mes2;

    }
}
