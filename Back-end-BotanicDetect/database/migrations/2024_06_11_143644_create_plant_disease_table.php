<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePlantDiseaseTable extends Migration
{
    public function up()
    {
        Schema::create('plant_disease', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('treatment')->nullable();
            $table->string('slug')->unique(); // Add slug column
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('plant_disease');
    }
}
