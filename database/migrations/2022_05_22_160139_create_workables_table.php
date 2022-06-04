<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_id');
            $table->morphs('workable');
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('workables');
    }
}
