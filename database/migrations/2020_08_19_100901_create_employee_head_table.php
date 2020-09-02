<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeHeadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_head', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('head_id');
            $table->unsignedBigInteger('employee_id')->nullable();

            $table->foreign('head_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');

            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
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
        Schema::dropIfExists('employee_head');
    }
}
