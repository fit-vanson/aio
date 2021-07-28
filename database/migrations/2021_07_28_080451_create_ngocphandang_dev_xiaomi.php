<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNgocphandangDevXiaomi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ngocphandang_dev_xiaomi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('xiaomi_ga_name')->nullable();
            $table->string('xiaomi_dev_name')->nullable();
            $table->string('xiaomi_store_name')->nullable();
            $table->string('xiaomi_email')->nullable();
            $table->string('xiaomi_pass')->nullable();
            $table->integer('xiaomi_status')->nullable();
            $table->string('xiaomi_note')->nullable();
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
        Schema::dropIfExists('ngocphandang_dev_xiaomi');
    }
}
