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
        Schema::create('clients_overview', function (Blueprint $table) {
            $table->id();
            $table->text('desc');
            $table->string('name');
            $table->text('designation');
            $table->tinyInteger('rating_star')->unsigned()->default(1);
            $table->string('image');
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
        Schema::dropIfExists('clients_overview');
    }
};
