<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
  public function run(): void
  {
    $adminrole = Role::create(['name' => 'admin']);
    $referrerRole = Role::create(['name' => 'referrer']);
    $referreredRole = Role::create(['name' => 'referrered']);
    $userrole = Role::create(['name' => 'user']);
  }
}
