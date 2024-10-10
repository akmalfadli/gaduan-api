<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periksas', function (Blueprint $table) {
            $table->id();
            $table->string('kondisi');
            $table->string('tubuh');
            $table->string('jenis_pakan');
            $table->integer('nilai');
            $table->text('deskripsi');
            $table->unsignedBigInteger('kambing_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');  
            $table->foreign('kambing_id')->references('id')->on('kambings');  
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
        Schema::dropIfExists('periksas');
    }
};
