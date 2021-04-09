<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('title');
            $table->string('slug');
            $table->unsignedInteger('category_id');
            $table->text('description');
            $table->boolean('agreement')->default(false);
            $table->double('price')->nullable();
            $table->string('price_type');
            $table->softDeletes();
            $table->timestamps();
        });

//        Schema::create('product_skill', function (Blueprint $table) {
//
//            $table->unsignedBigInteger('skill_id')->default(0);
//            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('cascade');
//
//            $table->unsignedBigInteger('product_id')->default(0);
//            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
//
//            $table->primary(['product_id','skill_id']);
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
//        Schema::dropIfExists('product_skill');
    }
}
