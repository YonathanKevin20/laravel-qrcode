<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'name' => 'Administrator',
                'email' => 'admin@qrcode.com',
                'password' => bcrypt('admin'),
                'role' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);

        DB::table('info_points')->insert([
            [
                'name' => 'import'
            ],
            [
                'name' => 'on time'
            ],
            [
                'name' => 'late'
            ]
        ]);

        DB::table('configurations')->insert([
            [
                'parameter' => 'start_time',
                'value' => '09:00:00',
                'description' => 'Jam Mulai',
                'type' => 'string'
            ],
            [
                'parameter' => 'end_time',
                'value' => '10:00:00',
                'description' => 'Jam Selesai',
                'type' => 'string'
            ],
            [
                'parameter' => 'on_time_point',
                'value' => '2',
                'description' => 'Poin Tepat Waktu',
                'type' => 'integer'
            ],
            [
                'parameter' => 'late_point',
                'value' => '1',
                'description' => 'Poin Terlambat',
                'type' => 'integer'
            ]
        ]);
    }
}
