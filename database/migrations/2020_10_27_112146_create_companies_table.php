<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('company_name');
            $table->string('person_name');
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->string('landline');
            $table->text('building_address');
            $table->text('company_address');
            $table->integer('apartment_count');
            $table->double('subscription_amount');
            $table->double('per_apartment_amount');
            $table->string('subscription_time');
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
        Schema::dropIfExists('companies');
    }
}
