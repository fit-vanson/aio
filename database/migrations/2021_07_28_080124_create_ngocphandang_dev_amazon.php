<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNgocphandangDevAmazon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ngocphandang_dev_amazon', function (Blueprint $table) {
            $table->increments('id');
            $table->string('amazon_ga_name')->nullable();
            $table->string('amazon_dev_name')->nullable();
            $table->string('amazon_store_name')->nullable();
            $table->string('amazon_email')->nullable();
            $table->string('amazon_pass')->nullable();
            $table->integer('amazon_status')->nullable();
            $table->string('amazon_note')->nullable();
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
        Schema::dropIfExists('ngocphandang_dev_amazon');
    }
}
