<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('category_id');
            $table->String('sub_category_name');
            $table->mediumText('description');
            $table->String('tag_line')->nullable();
            $table->mediumText('description_2')->nullable();
            $table->mediumText('cover_image_url')->nullable();
            $table->String('video_tag_line')->nullable();
            $table->mediumText('video_url')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('subcategories');
    }
}
