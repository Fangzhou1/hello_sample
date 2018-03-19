<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRreturntimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rreturntimes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('不具备决算送审条件')->index();
            $table->string('具备送审条件未送审')->index();
            $table->string('被退回')->index();
            $table->string('审计中')->index();
            $table->string('已出报告')->index();
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
        Schema::dropIfExists('rreturntimes');
    }
}
