<?php

use Illuminate\Database\Seeder;
use App\Models\Loginrecord;

class LoginrecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Loginrecord::class,50)->create();
    }
}
