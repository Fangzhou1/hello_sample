<?php

use Illuminate\Database\Seeder;
use App\Models\Settlementtime;

class SettlementtimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(Settlementtime::class,20)->create();

    }
}
