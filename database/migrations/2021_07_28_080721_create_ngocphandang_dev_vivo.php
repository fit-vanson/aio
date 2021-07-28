<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNgocphandangDevVivo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ngocphandang_dev_vivo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vivo_ga_name')->nullable();
            $table->string('vivo_dev_name')->nullable();
            $table->string('vivo_store_name')->nullable();
            $table->string('vivo_email')->nullable();
            $table->string('vivo_pass')->nullable();
            $table->integer('vivo_status')->nullable();
            $table->string('vivo_note')->nullable();
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
        Schema::dropIfExists('ngocphandang_dev_vivo');
    }
}
