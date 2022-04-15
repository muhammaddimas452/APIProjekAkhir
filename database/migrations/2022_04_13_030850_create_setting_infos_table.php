<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_infos', function (Blueprint $table) {
            $table->id();
            $table->string('lokasi_desa')->default(0)->nullable();
            $table->string('email_desa')->default(0)->nullable();
            $table->integer('nomor_hp1')->default(0)->nullable();
            $table->integer('nomor_hp2')->default(0)->nullable();
            $table->string('link_fb')->default(0)->nullable();
            $table->string('link_twitter')->default(0)->nullable();
            $table->string('link_ig')->default(0)->nullable();
            $table->string('link_yt')->default(0)->nullable();
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
        Schema::dropIfExists('setting_infos');
    }
}
