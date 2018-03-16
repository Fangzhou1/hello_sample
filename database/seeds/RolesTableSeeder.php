<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[['name'=>'游客','guard_name'=>'web'],['name'=>'项目经理','guard_name'=>'web'],['name'=>'高级管理员','guard_name'=>'web'],['name'=>'站长','guard_name'=>'web']];
        DB::table('roles')->insert($data);
    }
}
