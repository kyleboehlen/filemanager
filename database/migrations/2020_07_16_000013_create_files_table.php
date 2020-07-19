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
        Schema::create('files', function (Blueprint $table) {
            // Laravel columns
            $table->id();
            $table->timestamps();

            // Other columns
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('storage_location');
            $table->bigInteger('users_id')->unsigned();
            $table->string('slug')->unique();
            $table->string('attribution_name')->nullable();
            $table->string('attribution_url')->nullable();
            $table->integer('size');

            // Constraints
            $table->foreign('users_id')->references('id')->on('users');
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
