<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConciergesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concierges', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->bigInteger('gate_id')->unsigned();
            $table->foreign('gate_id')->references('id')->on('gates')->onDelete('cascade');
            $table->string('email')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('gender',['male','female']);
            $table->date('date_of_birth');
            $table->string('phone_number');
            $table->text('concierge_image')->nullable();
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('zip_code');
            $table->time('shift_start');
            $table->time('shift_end');
            $table->string('zip_code');
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
        Schema::dropIfExists('concierges');
    }
}
