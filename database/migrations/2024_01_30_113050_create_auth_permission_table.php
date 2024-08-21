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
        Schema::create('auth_permission', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('content_type_id');
            $table->string('codename');
                // codename is foreign key
            $table->foreign('content_type_id')->references('id')->on('django_content_type')->onDelete('cascade');
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
        Schema::dropIfExists('auth_permission');
    }
};
