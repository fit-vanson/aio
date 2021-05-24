<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NgocphandangProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ngocphandang_project', function (Blueprint $table) {
            $table->increments('projectid');
            $table->string('tempate');
            $table->string('ma_da');
            $table->string('package');
            $table->string('buildinfo_app_name_x');
            $table->string('buildinfo_store_name_x');
            $table->string('buildinfo_link_policy_x');
            $table->string('buildinfo_link_fanpage');
            $table->string('buildinfo_link_website');
            $table->string('buildinfo_link_store');
            $table->integer('buildinfo_vernum');
            $table->string('buildinfo_verstr');
            $table->string('buildinfo_keystore');
            $table->string('ads_id');
            $table->string('ads_banner');
            $table->string('ads_inter');
            $table->string('ads_reward');
            $table->string('ads_native');
            $table->string('ads_open');
            $table->string('buildinfo_console');
            $table->string('buildinfo_time');
            $table->string('buildinfo_mess');
            $table->string('time_mess');
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
        Schema::dropIfExists('ngocphandang_project');
    }
}
