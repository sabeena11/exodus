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
        Schema::create('auth_group_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id');
            $table->foreignId('permission_id');
            $table->foreign('group_id')->references('id')->on('auth_group')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('auth_permission')->onDelete('cascade');
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
        Schema::dropIfExists('auth_group_permissions');
    }
};
