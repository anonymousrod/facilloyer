<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('proprietaires', function (Blueprint $table) {
            $table->bigIncrements('id'); // Clé primaire auto-incrémentée
            $table->string('nom');
            $table->string('email')->unique();
            $table->string('telephone')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proprietaires');
    }
};

