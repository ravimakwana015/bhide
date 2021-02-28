<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->bigInteger('gate_id')->unsigned();
            $table->foreign('gate_id')->references('id')->on('gates')->onDelete('cascade');
            $table->bigInteger('reason_id')->unsigned();
            $table->foreign('reason_id')->references('id')->on('reason_for_visits')->onDelete('cascade');
            $table->bigInteger('unit_id')->unsigned();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->date('check_in_date');
            $table->time('check_in_time');
            $table->text('description')->nullable();
            $table->string('visitor_name');
            $table->string('id_number');
            $table->string('vehicle_number')->nullable();
            $table->date('check_out_date')->nullable();
            $table->time('check_out_time')->nullable();
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
        Schema::dropIfExists('visitors');
    }
}
