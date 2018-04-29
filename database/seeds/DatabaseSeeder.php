<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //$this->call(SettlementtimesTableSeeder::class);
        //$this->call(TracesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(LoginrecordsTableSeeder::class);
        //$this->call(UsersTableSeeder::class);
        //$this->call(RreturntimesTableSeeder::class);
    }
}
