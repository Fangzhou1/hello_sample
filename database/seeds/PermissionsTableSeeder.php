<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {



      $data=[
      ['name'=>"删除用户","route"=>"users.destroy","guard_name"=>"Web"],
      ['name'=>"结算审计更新","route"=>"settlements.rowupdate","guard_name"=>"Web"],
      ['name'=>"结算审计分类页面","route"=>"settlements.smsmail","guard_name"=>"Web"],
      ['name'=>"结算审计详情","route"=>"settlements.smsmaildetail","guard_name"=>"Web"],
      ['name'=>"结算审计发邮件","route"=>"settlements.sendemail","guard_name"=>"Web"],
      ['name'=>"结算审计统计","route"=>"settlements.statistics","guard_name"=>"Web"],
      ['name'=>"结算审计主页","route"=>"settlements.index","guard_name"=>"Web"],
      ['name'=>"结算审计新增页","route"=>"settlements.create","guard_name"=>"Web"],
      ['name'=>"结算审计新增","route"=>"settlements.store","guard_name"=>"Web"],
      ['name'=>"结算审计删除","route"=>"settlements.destroy","guard_name"=>"Web"],
      ['name'=>"决算审计更新","route"=>"rreturns.rowupdate","guard_name"=>"Web"],
      ['name'=>"决算审计分类页面","route"=>"rreturns.smsmail","guard_name"=>"Web"],
      ['name'=>"决算审计详情","route"=>"rreturns.smsmaildetail","guard_name"=>"Web"],
      ['name'=>"决算审计发邮件","route"=>"rreturns.sendemail","guard_name"=>"Web"],
      ['name'=>"决算审计统计","route"=>"rreturns.statistics","guard_name"=>"Web"],
      ['name'=>"决算审计主页","route"=>"rreturns.index","guard_name"=>"Web"],
      ['name'=>"决算审计新增页","route"=>"rreturns.create","guard_name"=>"Web"],
      ['name'=>"决算审计新增","route"=>"rreturns.store","guard_name"=>"Web"],
      ['name'=>"决算审计删除","route"=>"rreturns.destroy","guard_name"=>"Web"],
    ];

      DB::table('permissions')->insert($data);
    }
}
