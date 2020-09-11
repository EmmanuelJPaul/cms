<?php

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
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'test@gmail.com',
            'password' => Hash::make('admin#jit@cms'),
        ]);

        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'staff'],
            ['name' => 'student'],
            ['name' => 'guest'],
        ]);

        DB::table('role_user')->insert([
            'role_id' => '1',
            'user_id' => '1',
        ]);
    }
}
