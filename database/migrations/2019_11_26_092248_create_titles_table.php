<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class CreateTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titles', function (Blueprint $table) {
            $table->integer('emp_no')->nullable(false);
            $table->string('title', 50)->nullable(false);
            $table->date('from_date')->nullable(false);
            $table->date('to_date')->nullable(false);

            /*$table->foreign('emp_no')
                ->references('emp_no')
                ->on('employees')
                ->onDelete('cascade');*/
        });

        DB::unprepared('ALTER TABLE `titles` ADD PRIMARY KEY (  `emp_no` ,  `title` , `from_date`)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('titles');
    }
}
