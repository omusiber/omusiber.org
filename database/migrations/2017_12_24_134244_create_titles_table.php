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
            $table->string('about_us',30)->default('Hakkımızda');
            $table->string('projects',30)->default('Projelerimiz');
            $table->string('activities',30)->default('Etkinliklerimiz');
            $table->string('gallery',30)->default('Galeri');
            $table->string('members',30)->default('Üyelerimiz');
            $table->string('contact',30)->default('İletişim');
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
