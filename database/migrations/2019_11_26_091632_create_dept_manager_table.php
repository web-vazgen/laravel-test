<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDeptManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dept_manager', function (Blueprint $table) {
            $table->integer('emp_no')->nullable(false);
            $table->char('dept_no', 4)->nullable(false);
            $table->date('from_date')->nullable(false);
            $table->date('to_date')->nullable(false);

            $table->foreign('emp_no')
                ->references('emp_no')
                ->on('employees')
                ->onDelete('cascade');
            $table->foreign('dept_no')
                ->references('dept_no')
                ->on('departments')
                ->onDelete('cascade');
        });
        DB::unprepared('ALTER TABLE `dept_manager` ADD PRIMARY KEY (  `emp_no` ,  `dept_no` )');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dept_manager');
    }
}
