<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaper extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x2_paper', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('userid');
			$table->integer('scored');
			$table->integer('did_num');
			$table->integer('status');
			$table->integer('correct_num');
			$table->integer('keytype');
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
        Schema::drop('x2_paper');
    }
}
