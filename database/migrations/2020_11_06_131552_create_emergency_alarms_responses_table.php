<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmergencyAlarmsResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_alarms_responses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('alarm_id')->unsigned();
            $table->foreign('alarm_id')->references('id')->on('emergency_alarms')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('app_users')->onDelete('cascade');
            $table->tinyInteger('status')->default(0);
            $table->text('note')->nullable();
            $table->dateTime('response_date')->nullable();
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
        Schema::dropIfExists('emergency_alarms_responses');
    }
}
