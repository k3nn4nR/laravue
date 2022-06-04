<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_dates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_id')->unique();
            $table->date('started_at');
            $table->date('due_date');
            $table->timestamps();
            $table->foreign('work_id')->references('id')->on('works')->constrained()->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_dates');
    }
}
