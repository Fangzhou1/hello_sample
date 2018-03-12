<?php

namespace App\Listeners;

use App\Events\ModifyDates;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
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
      $trace = new Trace;
      $trace->type=$event->data['type'];
      $trace->created_at=Carbon::now();
      $trace->year=$trace->created_at->year;
      $trace->month=$trace->created_at->month;
      if($trace->type=='结算')
        $trace->content=$event->data['name']."于".$trace->created_at.$event->mes."结算表里订单编号为".$event->data['order_number']."的订单。";

      else
        $trace->content=$event->data['name']."于".$trace->created_at.$event->mes."决算表里项目编号为".$event->data['project_number']."的条目。";

      $trace->save();

    }
}
