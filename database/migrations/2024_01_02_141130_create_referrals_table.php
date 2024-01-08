<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('referrals', function (Blueprint $table) {
        $table->id();
        // $table->unsignedBigInteger('referrer_user_id');
        // $table->unsignedBigInteger('referred_user_id');
        $table->string('status')->default('pending');
        $table->string('reward_type')->nullable();
        $table->decimal('reward_value', 10, 2)->nullable();
        $table->dateTime('expiration_date')->nullable();
        $table->timestamps();
    
        $table->foreign('referrer_user_id')->references('id')->on('users');
        $table->foreign('referred_user_id')->references('id')->on('users');
    });
}


    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
