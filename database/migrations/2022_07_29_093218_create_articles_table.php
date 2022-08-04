<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_category_id');
            $table->string('title');
            $table->string('slug');
            $table->longText('contents');
            $table->string('image_path');
            $table->unsignedBigInteger('updated_user_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('article_category_id')->references('id')->on('article_category');

            $table->foreign('updated_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
};
