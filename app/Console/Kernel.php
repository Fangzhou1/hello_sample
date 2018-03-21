<?php

namespace App\Console;
use \App\Models\Settlementtime;
use \App\Models\Settlement;
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
        Commands\InitEs::class
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

        })->everyMinute();
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
}
