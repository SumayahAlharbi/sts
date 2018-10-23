<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Location extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('locations', function (Blueprint $table) {
           $table->increments('id');
           $table->string('location_name');
           $table->string('location_description');
           $table->integer('group_id');
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
        //
    }
}
