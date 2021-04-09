<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('label');
            $table->string('slug');
            $table->string('order_number')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('category_skill', function (Blueprint $table) {

            $table->unsignedBigInteger('skill_id')->default(0);
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('cascade');

            $table->unsignedBigInteger('category_id')->default(0);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->primary(['category_id','skill_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
