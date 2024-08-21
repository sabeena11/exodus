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
        Schema::create('user_reports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('mobile')->nullable();
            $table->tinyInteger('mobile_verified');
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->string('image')->nullable();
                       
            $table->dateTime('last_login')->nullable();
            $table->tinyInteger('is_superuser');
                       
            $table->smallInteger('sex');
            $table->decimal('point');
            $table->string('address')->nullable();
            $table->date('dob')->nullable();
            $table->tinyInteger('is_staff');
            $table->tinyInteger('is_verified');
          
            $table->string('fcm');
            $table->foreignId('user_id');
            $table->foreignId('branch_id');
            $table->string('categories');
            $table->foreign('user_id')->references('id')->on('coreapp_user');
            $table->foreign('branch_id')->references('id')->on('rewardapp_branch');
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
        Schema::dropIfExists('user_reports');
    }
};
