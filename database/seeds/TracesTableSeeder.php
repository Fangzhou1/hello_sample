<?php

use Illuminate\Database\Seeder;
use App\Models\Trace;

class TracesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Trace::class,100)->create();
    }
}
