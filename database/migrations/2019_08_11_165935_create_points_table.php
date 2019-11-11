<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('child_id')->unsigned();
            $table->integer('qty')->unsigned();
            $table->integer('info_point_id')->unsigned();
            $table->integer('time')->unsigned();

            $table->foreign('child_id')
                ->references('id')
                ->on('children')
                ->onDelete('cascade');
            $table->foreign('info_point_id')
                ->references('id')
                ->on('info_points');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('points');
    }
}
