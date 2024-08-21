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
        Schema::create('rewardapp_updatelog', function (Blueprint $table) {
            $table->id();
            $table->text('data');
            $table->date('created');
            $table->foreignId('end_device_id'); 
            $table->foreign('end_device_id')->references('id')->on('rewardapp_enddevice');
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
        Schema::dropIfExists('rewardapp_updatelog');
    }
};
