<?php

namespace Database\Seeders;
use App\Models\User;
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
        User::truncate();
          User::create([
             'name' => 'admin1',
             'no_rekam_medis' => null,
             'level' => 'Admin',
             'status' => 0,
             'username' => 'Admin Devan',
             'password' => bcrypt('admin12345'),
          ]);
    }
}
