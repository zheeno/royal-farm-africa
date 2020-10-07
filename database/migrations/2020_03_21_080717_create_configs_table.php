<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            // contact details
            $table->String('contact_address_1')->nullable();
            $table->String('contact_address_2')->nullable();
            $table->String('contact_phone_1')->nullable();
            $table->String('contact_phone_2')->nullable();
            $table->String('contact_email_1')->nullable();
            $table->String('contact_email_2')->nullable();
            // terms and conditions
            $table->mediumText('terms_of_sponsorship')->nullable();
            $table->mediumText('terms_of_use')->nullable();
            $table->mediumText('terms_of_farm_visit')->nullable();
            $table->mediumText('privacy_policy')->nullable();
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
        Schema::dropIfExists('configs');
    }
}
