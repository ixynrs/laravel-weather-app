<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('search_histories', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('country', 2);
            $table->json('weather_data');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('search_histories');
    }
}
