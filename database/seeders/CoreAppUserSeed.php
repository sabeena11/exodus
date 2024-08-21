<?php

namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CoreAppUserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coreapp_user')->insert([
            'id' => '-1',
            'last_login' => '2024-02-07 17:30:22',
            'is_superuser' => true,
            'phone' => '1234567890',
            'sex' => true,
            'point' => '100',
            'address' => Str::random(10),
            'dob' => '2024-02-07',
            'is_staff' => true,
            'is_verified' => true,
            'date_created' => '2024-02-07 17:30:22',
            'date_modified' => '2024-02-07 17:30:22',
            'picture' => Str::random(10),
            'fcm' => Str::random(10),
            'name' => Str::random(10),
            'email' => Str::random(10).'@example.com',
            'password' => Hash::make('123456'),
        ]);
    }
}
