<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
  public function run(): void
  {
    $user = User::create([
      'name' => 'admin',
      'email' => 'admin@xyz.com',
      // 'email_verified' => now(),
      'password' => 'password'
    ]);

    $user->assignRole('admin');
  }
}
