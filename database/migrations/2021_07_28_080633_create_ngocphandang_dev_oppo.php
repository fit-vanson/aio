<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNgocphandangDevOppo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ngocphandang_dev_oppo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('oppo_ga_name')->nullable();
            $table->string('oppo_dev_name')->nullable();
            $table->string('oppo_store_name')->nullable();
            $table->string('oppo_email')->nullable();
            $table->string('oppo_pass')->nullable();
            $table->integer('oppo_status')->nullable();
            $table->string('oppo_note')->nullable();
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
        Schema::dropIfExists('ngocphandang_dev_oppo');
    }
}
