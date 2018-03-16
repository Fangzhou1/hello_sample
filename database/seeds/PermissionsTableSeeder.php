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
      ['name'=>"结算批量导入页","route"=>"settlements.importpage","guard_name"=>"Web"],
      ['name'=>"结算批量导入","route"=>"settlements.import","guard_name"=>"Web"],
      ['name'=>"决算批量导入页","route"=>"rreturns.importpage","guard_name"=>"Web"],
      ['name'=>"决算批量导入","route"=>"rreturns.import","guard_name"=>"Web"],
      ['name'=>"权限主页","route"=>"permissions.index","guard_name"=>"Web"],
      ['name'=>"新增权限页","route"=>"permissions.create","guard_name"=>"Web"],
      ['name'=>"新增权限","route"=>"permissions.store","guard_name"=>"Web"],
      ['name'=>"删除权限","route"=>"permissions.destroy","guard_name"=>"Web"],
      ['name'=>"更新权限","route"=>"permissions.rowupdate","guard_name"=>"Web"],
      ['name'=>"角色主页","route"=>"roles.index","guard_name"=>"Web"],
      ['name'=>"新增角色页","route"=>"roles.create","guard_name"=>"Web"],
      ['name'=>"新增角色","route"=>"roles.store","guard_name"=>"Web"],
      ['name'=>"删除角色","route"=>"roles.destroy","guard_name"=>"Web"],
      ['name'=>"给角色赋予权限","route"=>"roles.permissionstorole","guard_name"=>"Web"],
      ['name'=>"更新角色","route"=>"roles.rowupdate","guard_name"=>"Web"],
      ['name'=>"用户列表页","route"=>"users.index","guard_name"=>"Web"],
      ['name'=>"用户展示页","route"=>"users.show","guard_name"=>"Web"],
      ['name'=>"用户处理页","route"=>"users.edit","guard_name"=>"Web"],
      ['name'=>"更新用户","route"=>"users.update","guard_name"=>"Web"],
      ['name'=>"删除用户","route"=>"users.destroy","guard_name"=>"Web"],
      ['name'=>"用户处置列表页","route"=>"users.usersactionindex","guard_name"=>"Web"],
      ['name'=>"给用户赋予角色页","route"=>"users.rolestouserpage","guard_name"=>"Web"],
      ['name'=>"给用户赋予角色","route"=>"users.rolestouser","guard_name"=>"Web"],
      ['name'=>"给角色赋予权限页","route"=>"roles.permissionstorolepage","guard_name"=>"Web"],
      ['name'=>"导出结算总表","route"=>"settlements.export","guard_name"=>"Web"],
      ['name'=>"导出决算总表","route"=>"rreturns.export","guard_name"=>"Web"],
      ['name'=>"按分类导出结算分表","route"=>"settlements.exportbytype","guard_name"=>"Web"],
      ['name'=>"按分类导出决算分表","route"=>"rreturns.exportbytype","guard_name"=>"Web"],
    ];





      DB::table('permissions')->insert($data);
    }
}
