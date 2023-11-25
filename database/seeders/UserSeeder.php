<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        User::create([
            'name' => 'مالك علي',
            'username' => 'admin',
            'password' => Hash::make(123456)
        ]);

        User::create([
            'name' => 'مستخدم اخر',
            'username' => 'worker',
            'password' => Hash::make(123456)
        ]);

    }
}
