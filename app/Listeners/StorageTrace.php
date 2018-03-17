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
      $ret=Settlement::where("project_number",$event->data['project_number'])->whereIn("audit_progress",$audit_progress_arr)->get();
      $rreturn=Rreturn::where('project_number',$event->data['project_number'])->first();
      if($trace->type=='结算')
        {
        $trace->content=$event->data['name']."于".$trace->created_at.$event->mes."结算表里订单编号为".$event->data['order_number']."的订单。";
          if($rreturn)
          {
              if($ret->isEmpty())
                  {
                    $rreturn->is_canaudit='是';
                    $rreturn->save();
                    $mes2="并且项目编号为".$event->data['project_number']."的项目结算已全部完成，可以开始决算审计了！";
                    $trace->content=$trace->content.$mes2;
                  }
                elseif($rreturn->is_canaudit=='是')
                  {
                    $rreturn->is_canaudit='否';
                    $rreturn->save();
                    $mes2="项目编号为".$event->data['project_number']."的项目结算审计未全部完成，此项目决算审计回退至不具备条件！";
                    $trace->content=$trace->content.$mes2;
                  }

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
                $rreturn->is_canaudit='是';
                $rreturn->save();
                $mes2="并且项目编号为".$event->data['project_number']."的项目结算已全部完成，可以开始决算审计了！";
                $trace->content=$trace->content.$mes2;
              }
              elseif($rreturn->is_canaudit=='是')
              {
                $rreturn->is_canaudit='否';
                $rreturn->save();
                $mes2="项目编号为".$event->data['project_number']."的项目结算审计未全部完成，此项目决算审计回退至不具备条件！";
                $trace->content=$trace->content.$mes2;
              }

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
