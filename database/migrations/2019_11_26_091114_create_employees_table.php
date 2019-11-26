<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->integer('emp_no')->nullable(false)->primary();
            $table->date('birth_date')->nullable(false);
            $table->string('first_name', 14)->nullable(false);
            $table->string('last_name', 16)->nullable(false);
            $table->enum('gender', ['M', 'F'])->nullable(false);
            $table->date('hire_date')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
