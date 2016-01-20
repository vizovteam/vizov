<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('sort_id');
            $table->integer('section_id')->unsigned();
            $table->foreign('section_id')->references('id')->on('section');
            $table->string('slug');
            $table->string('title');
            $table->string('image');
            $table->string('title_description');
            $table->string('meta_description');
            $table->text('text');
            $table->char('lang', 2)->default('ru');
            $table->integer('status')->default(1);
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
        //
    }
}
