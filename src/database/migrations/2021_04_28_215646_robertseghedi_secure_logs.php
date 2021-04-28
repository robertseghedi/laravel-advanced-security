<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecureLogsTablesx extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('robertseghedi_secure_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user')->default(0);
            $table->longText('string');
            $table->string('ip');
            $table->string('os');
            $table->string('browser');
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
        Schema::dropIfExists('robertseghedi_secure_logs');
    }
}
