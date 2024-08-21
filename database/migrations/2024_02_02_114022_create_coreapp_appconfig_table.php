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
        Schema::create('coreapp_appconfig', function (Blueprint $table) {
            $table->id();
        
            $table->longText('sms_token');
            $table->integer('reward_value');
            $table->boolean('enable_sms')->nullable(); // 0 or 1
            $table->boolean('enable_notifications')->nullable(); // 0 or 1

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
        Schema::dropIfExists('coreapp_appconfig');
    }
};