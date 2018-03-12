<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRreturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rreturns', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('project_duration')->index()->nullable();
            $table->string('project_number')->index()->nullable();
            $table->string('project_name')->index()->nullable();
            $table->string('project_manager')->index()->nullable();
            $table->string('audit_progress')->index()->nullable();
            $table->string('audit_document_number')->index()->nullable();
            $table->string('audit_company')->index()->nullable();
            $table->string('is_needsaudit')->default('是');
            $table->string('is_canaudit')->default('否');
            $table->string('audit_number')->index()->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('rreturns');
    }
}
