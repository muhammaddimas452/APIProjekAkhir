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
            $table->string('lokasi_desa');
            $table->string('email_desa');
            $table->integer('nomor_hp1');
            $table->integer('nomor_hp2');
            $table->string('link_fb');
            $table->string('link_twitter');
            $table->string('link_ig');
            $table->string('link_yt');
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
