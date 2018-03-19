<?php

use Illuminate\Database\Seeder;
use App\Models\Rreturntime;

class RreturntimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Rreturntime::class,20)->create();
    }
}
