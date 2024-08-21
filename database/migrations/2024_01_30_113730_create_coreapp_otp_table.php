<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coreapp_otp', function (Blueprint $table) {
            $table->id();
    
            $table->dateTime('expire_time');
            $table->integer('otpCode');
            $table->tinyInteger('is_verified'); // 0 or 1
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('coreapp_user')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coreapp_otp');
    }
};
