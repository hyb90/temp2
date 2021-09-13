<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->string('body');
            $table->string('receiver');
            $table->integer('number_of_attempts')->default(0);
            $table->integer('status')->default(0); // 0 = pending , 1= success , 2 =fail
            $table->integer('type')->default(0); // 0 = email , 1= sms
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
