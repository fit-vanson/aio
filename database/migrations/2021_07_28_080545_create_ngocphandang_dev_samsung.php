<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNgocphandangDevSamsung extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ngocphandang_dev_samsung', function (Blueprint $table) {
            $table->increments('id');
            $table->string('samsung_ga_name')->nullable();
            $table->string('samsung_dev_name')->nullable();
            $table->string('samsung_store_name')->nullable();
            $table->string('samsung_email')->nullable();
            $table->string('samsung_pass')->nullable();
            $table->integer('samsung_status')->nullable();
            $table->string('samsung_note')->nullable();
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
        Schema::dropIfExists('ngocphandang_dev_samsung');
    }
}
