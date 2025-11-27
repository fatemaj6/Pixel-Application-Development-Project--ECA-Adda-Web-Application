<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('institution')->nullable();
            $table->string('education_level')->nullable();
            $table->enum('package_type', ['tier1','tier2'])->default('tier2');
            $table->enum('role', ['user','admin'])->default('user');
            $table->string('otp_code')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->string('payment_status')->default('pending');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone','institution','education_level','package_type',
                'role','otp_code','otp_expires_at','payment_status'
            ]);
        });
    }
};
?>