<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsorshipReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsorship_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('user_id');
            $table->String('sponsorship_id');
            $table->boolean('is_author_sponsor')->default(false);
            $table->Integer('num_stars');
            $table->mediumText('review');
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
        Schema::dropIfExists('sponsorship_reviews');
    }
}
