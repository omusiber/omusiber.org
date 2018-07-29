<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('about_us',30)->default('HAKKIMIZDA');
            $table->string('calendar',30)->default('TAKVİM');
            $table->string('projects',30)->default('PROJELERİMİZ');
            $table->string('activities',30)->default('ETKİNLİKLERİMİZ');
            $table->string('gallery',30)->default('GALERİ');
            $table->string('members',30)->default('ÜYELİK');
            $table->string('contact',30)->default('İLETİŞİM');
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
        Schema::dropIfExists('titles');
    }
}
