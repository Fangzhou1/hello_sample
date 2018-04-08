<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class InitProjectmanager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Projectmanager:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'init Projectmanager';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data=[['name'=>'童方杰','email'=>'13986151412@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'王守钦','email'=>'13971601068@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'刘欢欢','email'=>'13995530181@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'巫强','email'=>'13807100258@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'陶宏波','email'=>'13707171212@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'管燕','email'=>'13871540393@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'王鹏','email'=>'13871008080@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'袁新耀','email'=>'13995555996@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'肖黎','email'=>'13707179967@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'赵文宁','email'=>'18702710715@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'李晓林','email'=>'13871406263@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'杨华','email'=>'13871308000@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'范洵','email'=>'13871378849@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'陈敬忠','email'=>'13807100789@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'盖晶晶','email'=>'13995668199@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'杨波','email'=>'13437188855@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'于轩','email'=>'13886127257@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'冯仕坤','email'=>'15827090981@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'陈卓','email'=>'13545210925@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'王虓','email'=>'13971453003@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'秦君','email'=>'15802780301@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'刘涛','email'=>'13707195558@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'宗良辉','email'=>'13971580442@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'夏冬','email'=>'15871696777@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'张立','email'=>'13971387100@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'许应秋','email'=>'13971601127@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'王占力','email'=>'13871516786@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'王恒','email'=>'13995673567@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'师文武','email'=>'13871340535@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'邹碧霄','email'=>'13667252205@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'屠飞','email'=>'13545050014@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'苏毅','email'=>'15827366669@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'胡世平','email'=>'13507194906@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
               ['name'=>'沈小燕','email'=>'15872386491@139.com','password'=>bcrypt('123456'),'activated'=>true,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],

      ];
        DB::table('users')->insert($data);
        $this->info('项目经理创建成功');
    }
}
