<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('eca_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('eca_id');
            $table->timestamps();

            $table->unique(['user_id', 'eca_id']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('eca_id')->references('id')->on('ecas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('eca_user');
    }
};
?>