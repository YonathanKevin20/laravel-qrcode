<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('children', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('gender', ['m', 'f']);
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->integer('grade_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('grade_id')
                ->references('id')
                ->on('grades')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('children');
    }
}
