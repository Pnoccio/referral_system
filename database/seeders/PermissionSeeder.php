<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
  public function run(): void
  {
    // permissions
    $manageUserPermissions = Permission::create(['name' => 'manage users']);
    $manageRolesPermission = Permission::create(['name' => 'manage roles']);
    $managePermissionPermission = Permission::create(['name' => 'manage permissions']);
    $manageReferralsPermission = Permission::create(['name' => 'manage referrals']);
    $viewReferralsPermission = Permission::create(['name' => 'view referrals']);
    $updateReferralsDetailsPermission = Permission::create(['name' => 'update referrals details']);
    $manageProductPermission = Permission::create(['name' => 'manage products']);
    $viewProductPermission = Permission::create(['name' => 'view products']);
    $createOrdersPermission = Permission::create(['name' => 'create orders']);
    $viewOrdersPermission = Permission::create(['name' => 'view orders']);
    $processPaymentsPermission = Permission::create(['name' => 'process payments']);
    $editArticlePermission = Permission::create(['name' => 'edit articles']);

    // roles
    $adminRole = Role::findById(1);
    $adminRole->givePermissionTo([
      $manageUserPermissions,
      $manageRolesPermission,
      $managePermissionPermission,
      $manageReferralsPermission,
      $viewReferralsPermission,
      $updateReferralsDetailsPermission,
      $manageProductPermission,
      $viewProductPermission,
      $createOrdersPermission,
      $viewOrdersPermission,
      $processPaymentsPermission,
      $editArticlePermission,
    ]);

    $referralRole = Role::findById(2);
    $referralRole->givePermissionTo([
      $viewReferralsPermission,
      // $simulatePurchasePermission
    ]);

    $referredRole = Role::findById(3);
    $referredRole->givePermissionTo([
      $createOrdersPermission,
      $viewOrdersPermission,
      $processPaymentsPermission
    ]);

    $regularUser = Role::findById(4);
    $regularUser->givePermissionTo([
      $createOrdersPermission,
      $viewOrdersPermission,
      $processPaymentsPermission
    ]);
  }
}
