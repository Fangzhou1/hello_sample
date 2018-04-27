<?php

namespace App\Console;
use \App\Models\Settlementtime;
use \App\Models\Settlement;
use \App\Models\Rreturntime;
//use \App\Models\Rreturn;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\InitEs::class,
        Commands\CreateFounder::class,
        Commands\InitProjectmanager::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {

          $data=$this->readSettlementProgress();
          Settlementtime::create($data);
          $this->readRreturnProgressandcreate();

        })->dailyAt('3:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }




    protected function readSettlementProgress()
    {

      $data= Settlement::where('audit_progress','已出报告')->select(DB::raw('count(*) as finished_ordernum'))->first()->toArray();
      $data2=DB::table('settlements')->where('order_number','<>','订单编号')->select(DB::raw('count(*) as ordernum,audit_progress,project_number'))->groupBy('project_number','audit_progress')->get();

      foreach ($data2 as $value) {
        $newdata_tem[$value->project_number][$value->audit_progress]=$value->ordernum;
      }
      $newdata3=['finished_projectnum'=>0];
      foreach ($newdata_tem as $value) {
        if(!(isset($value['审计中'])||isset($value['未送审'])||isset($value['被退回'])))
          $newdata3['finished_projectnum']+=1;

      }
    $data3=array_merge($data,$newdata3);
    return $data3;

    }

    protected function readRreturnProgressandcreate()
    {
      $data=DB::table('rreturns')->where('project_number','<>','项目编号')->select(DB::raw('count(*) as projectnum,audit_progress,is_canaudit'))->groupBy('is_canaudit','audit_progress')->get();
    //dd($data);
    $newdata3=[];
      foreach ($data as $value) {
        if($value->audit_progress=='未送审'&&$value->is_canaudit=='否')
          $newdata3['不具备决算送审条件']=$value->projectnum;
        elseif($value->audit_progress=='未送审'&&$value->is_canaudit=='是')
          $newdata3['具备送审条件未送审']=$value->projectnum;
        elseif($value->audit_progress=='审计中')
          $newdata3['审计中']=$value->projectnum;
        elseif($value->audit_progress=='被退回')
          $newdata3['被退回']=$value->projectnum;
        elseif($value->audit_progress=='已出报告')
          $newdata3['已出报告']=$value->projectnum;

      }

      Rreturntime::create($newdata3);
    }

    protected function readRefundProgressandcreate()
    {
    // //  ,sum("cash_refund") as cash_refund_total,sum("direct_yes") as direct_yes_total,sum("direct_no") as direct_no_total'),'
  //      $data=DB::table('refunds')->where('project_manager','<>','项目经理')->select(DB::raw('sum("thing_refund") as thing_refund_total,sum("cash_refund") as cash_refund_total',sum("cash_refund") as cash_refund_total),sum("direct_yes") as direct_yes_total,sum("unrefund_cost") as unrefund_cost_total)->get();
  // dd($data);
    // $newdata3=[];
    //   foreach ($data as $value) {
    //     if($value->audit_progress=='未送审'&&$value->is_canaudit=='否')
    //       $newdata3['不具备决算送审条件']=$value->projectnum;
    //     elseif($value->audit_progress=='未送审'&&$value->is_canaudit=='是')
    //       $newdata3['具备送审条件未送审']=$value->projectnum;
    //     elseif($value->audit_progress=='审计中')
    //       $newdata3['审计中']=$value->projectnum;
    //     elseif($value->audit_progress=='被退回')
    //       $newdata3['被退回']=$value->projectnum;
    //     elseif($value->audit_progress=='已出报告')
    //       $newdata3['已出报告']=$value->projectnum;
    //
    //   }
    //
    //   Rreturntime::create($newdata3);
    }

}
