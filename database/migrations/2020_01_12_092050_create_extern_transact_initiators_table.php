<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternTransactInitiatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extern_transact_initiators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('local_tran_ref');
            $table->string('extern_tran_ref')->nullable();
            $table->float('amount');
            $table->string('description');
            $table->string('extern_platform');
            $table->boolean('processed')->default(false);
            $table->boolean('successful')->default(false);
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
        Schema::dropIfExists('extern_transact_initiators');
    }
}
