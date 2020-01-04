<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsorshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsorships', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('category_id');
            $table->String('sub_category_id');
            $table->String('title');
            $table->mediumText('description');
            $table->String('location_id');
            $table->Integer('total_units');
            $table->Integer('duration_in_months');
            $table->float('price_per_unit');
            $table->float('expected_returns_pct');
            $table->boolean('is_active')->default(true);
            $table->boolean('in_progress')->default(false);
            $table->boolean('is_completed')->default(false);
            $table->dateTime('expected_completion_date');
            $table->dateTime('actual_completion_date')->nullable();
            $table->timestamps();
        });
    }
    // php artisan make:migration add_mobile_no_columns_to_users_table --table=users

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sponsorships');
    }
}
