<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRealEstatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_estates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->string('title', 191);
            $table->text('description');
            $table->double('price');
            $table->text('address');
            $table->string('beds', 191);
            $table->string('baths', 191);
            $table->string('lease_length', 191);
            $table->enum('furnished', array('Yes', 'No'));
            $table->text('facilities');
            $table->text('images');
            $table->string('availability', 191);
            $table->string('email', 191);
            $table->string('phone', 191);
            $table->string('enquiry_by', 191);
            $table->enum('status', array('Active', 'Inactive', 'Let Agreed', 'Sale Agreed'));
            $table->datetime('expiry_date');
            $table->enum('property_type', array('For Rent','For Sale'));
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('app_users')->onDelete('cascade');
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
        Schema::dropIfExists('real_estates');
    }
}
