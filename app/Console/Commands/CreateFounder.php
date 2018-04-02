<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateFounder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'founder:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create founder';

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
      $data=['name'=>'fangzhou8','email'=>'13971192688@139.com','password'=>bcrypt('123456'),'activated'=>true];
      $user=User::create($data);
      $user->assignRole('站长');
      $this->info('站长角色创建成功');
    }
}
