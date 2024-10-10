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
        Schema::create('kambings', function (Blueprint $table) {
            $table->id();
            $table->string('tag_id')->unique();
            $table->string('winih_id');
            $table->string('jenis_kambing');
            $table->string('tgl_lahir');
            $table->unsignedBigInteger('penerima_id');
            $table->foreign('penerima_id')->references('id')->on('penerimas');  
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
        Schema::dropIfExists('kambings');
    }
};
