<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
  // create_comments_table

  public function up()
  {
      Schema::create('comments', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('user_id')->unsigned();
         $table->integer('parent_id')->unsigned();
         $table->text('body');
         $table->integer('commentable_id')->unsigned();
         $table->string('commentable_type');
         $table->timestamps();
         $table->softDeletes();
      });
  }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
