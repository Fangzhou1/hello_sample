<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class,30)->create();
        $user = User::find(1);
        $user->name = 'fangzhou';
        $user->email = '13971192686@139.com';
        $user->password = bcrypt('123456');
        $user->is_admin = true;
        $user->activated = true;
        $user->save();
    }
}
