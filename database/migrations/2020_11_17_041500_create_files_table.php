<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // youtube_id, name, path, file_size, file_name,  file_hash, file_type
        Schema::create('files', function (Blueprint $table) {
            $table->string('youtube_id',11);
            $table->string('name');
            $table->string('path')->unique();
            $table->unsignedInteger('file_size');
            $table->string('filename');
            $table->string('file_hash',32)->unique();
            $table->string('file_type',5);
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
        Schema::dropIfExists('files');
    }
}
