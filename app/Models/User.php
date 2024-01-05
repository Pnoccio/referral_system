<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable, HasRoles;

  
  protected $fillable = [
    'name',
    'email',
    'password',
    'role_id'
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
  ];

  public function role(){
    return $this->belongsTo(Role::class);
  }

  public function referredBy(){
    return $this->hasMany(Referrals::class, 'referred_user_id');
  }

  public function referredUser(){
    return $this->hasMany(Referrals::class, 'referrer_user_id');
  }
}
