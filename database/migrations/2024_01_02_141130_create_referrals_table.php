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
        $table->foreignId('referrer_user_id')->nullable()->default(null)->constrained('users');
        $table->foreignId('referred_user_id')->constrained('users');
        $table->string('status');
        $table->string('reward_type');
        $table->decimal('reward_value', 10, 2);
        $table->timestamp('expiration_date')->nullable();
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
