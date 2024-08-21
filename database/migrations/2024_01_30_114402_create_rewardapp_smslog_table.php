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
        
        Schema::create('rewardapp_smslog', function (Blueprint $table) {
            $table->id();
            $table->text('response');
            $table->string('message');
            $table->date('created');
            $table->foreignId('user_id');
            $table->tinyInteger('success');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('rewardapp_smslog');
    }
};
