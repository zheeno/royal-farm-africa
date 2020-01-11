<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('avatar_url')->nullable();
            $table->string('avatar_file_name')->nullable();
            // bio
            $table->string('dob');
            $table->string('gender');
            $table->string('phone_no');
            $table->string('nationality');
            $table->string('occupation');
            // contact
            $table->mediumText('address');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            // bank details
            $table->string('account_name');
            $table->string('account_number');
            $table->string('bank_name');
            $table->string('bvn')->nullable();
            // next of kin details
            $table->string('nok_surname')->nullable();
            $table->string('nok_firstname');
            $table->string('nok_relationship');
            $table->string('nok_email');
            $table->string('nok_phone');
            $table->string('nok_address');
            // social media
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();

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
        Schema::dropIfExists('profiles');
    }
}
