<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([['name'=>'游客',"guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],['name'=>'项目经理',"guard_name"=>"web","created_ti  me"=>Carbon::now(),"updated_at"=>Carbon::now()],['name'=>'高级管理员',"guard_name"=>"web","created_at"=>Carbon::now(),'updated_at'=>Carbon::now()],['name'=>'站长',"guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()]]);
        $role=Role::where('name','站长')->first();
        $role->givePermissionTo(["结算审计更新","结算审计分类页面","结算审计详情","结算审计发邮件","结算审计统计","结算审计主页","结算审计新增页","结算审计新增","结算审计删除","决算审计更新","决算审计分类页面","决算审计详情","决算审计发邮件","决算审计统计","决算审计主页","决算审计新增页","决算审计新增","决算审计删除","结算批量导入页","结算批量导入","决算批量导入页","决算批量导入","权限主页","新增权限页","新增权限","删除权限","更新权限",
          "角色主页","新增角色页","新增角色","删除角色","给角色赋予权限","更新角色","用户列表页","用户展示页","用户更新页","更新用户","删除用户","用户处置列表页","给用户赋予角色页","给用户赋予角色","给角色赋予权限页","导出结算总表","导出决算总表","按分类导出结算分表","按分类导出决算分表"]);
    }
}
