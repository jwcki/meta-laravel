<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntryImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entry_images', function (Blueprint $table) {
            $table->string('imdbID');
            $table->string('url');
            $table->timestamps();

            $table->primary('imdbID');
            $table->foreign('imdbID')
                ->references('imdbID')
                ->on('entries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entry_images');
    }
}
