<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsorCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsor_carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('user_id');
            $table->String('session_id');
            $table->String('sponsorship_id');
            $table->Integer('units');
            $table->float('price_per_unit');
            $table->float('expected_return_pct');
            $table->float('total_capital');
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
        Schema::dropIfExists('sponsor_carts');
    }
}
