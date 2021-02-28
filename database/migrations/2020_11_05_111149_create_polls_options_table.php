<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollsOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls_options', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('poll_id')->unsigned();
            $table->foreign('poll_id')->references('id')->on('polls')->onDelete('cascade');
            $table->text('option');
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
        Schema::dropIfExists('polls_options');
    }
}
