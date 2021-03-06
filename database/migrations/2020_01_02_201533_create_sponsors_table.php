<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('user_id');
            $table->String('sponsorship_id');
            $table->Integer('units');
            $table->float('price_per_unit');
            $table->float('expected_return_pct');
            $table->float('received_returns_pct')->nullable();
            $table->boolean('has_received_returns')->default(false);
            $table->float('actual_returns_received')->default(0);
            $table->float('total_capital');
            $table->String('transaction_id');
            $table->String('transaction_ref_id');
            $table->String('payment_method')->nullable();
            $table->boolean('has_paid')->default(false);
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
        Schema::dropIfExists('sponsors');
    }
}
