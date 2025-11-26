<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileAndOtpToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('institution')->nullable()->after('phone');
            $table->string('education_level')->nullable()->after('institution');
            $table->enum('package_type', ['tier1','tier2'])->default('tier2')->after('education_level');
            $table->enum('role', ['user','admin'])->default('user')->after('package_type');
            $table->string('otp_code')->nullable()->after('role');
            $table->timestamp('otp_expires_at')->nullable()->after('otp_code');
            $table->string('payment_status')->default('pending')->after('otp_expires_at');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'institution',
                'education_level',
                'package_type',
                'role',
                'otp_code',
                'otp_expires_at',
                'payment_status',
            ]);
        });
    }
}
?>