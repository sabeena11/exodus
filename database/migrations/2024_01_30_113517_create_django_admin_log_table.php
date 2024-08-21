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
        Schema::create('django_admin_log', function (Blueprint $table) {
            $table->id();
            $table->dateTime('action_time');
            $table->longText('object_id');
            $table->string('object_repr');
            $table->smallInteger('action_flag');
            $table->longText('change_message');
            $table->unsignedinteger('content_type_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('content_type_id')->references('id')->on('django_content_type');
            $table->foreign('user_id')->references('id')->on('coreapp_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('django_admin_log');
    }
};
