<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
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
        Schema::dropIfExists('users');
    }
}
