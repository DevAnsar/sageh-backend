<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_skills', function (Blueprint $table) {
            $table->unsignedBigInteger('skill_id')->default(0);
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('cascade');

            $table->unsignedBigInteger('question_id')->default(0);
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');

            $table->primary(['question_id','skill_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_skills');
    }
}
