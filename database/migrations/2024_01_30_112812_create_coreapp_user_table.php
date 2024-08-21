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
        Schema::create('coreapp_user', function (Blueprint $table) {
            $table->id();
            $table->string('password');
            $table->dateTime('last_login')->nullable();
            $table->tinyInteger('is_superuser');
            $table->string('email');
            $table->string('name');
            $table->string('phone');                            //hold a key          
            $table->smallInteger('sex');
            $table->decimal('point');
            $table->string('address')->nullable();
            $table->date('dob')->nullable();
            $table->tinyInteger('is_staff');
            $table->tinyInteger('is_verified');
            $table->dateTime('date_created');
            $table->dateTime('date_modified');
            $table->string('picture')->nullable();
            $table->string('fcm');
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
        Schema::dropIfExists('coreapp_user');
    }
};
