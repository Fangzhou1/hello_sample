<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('order_number')->index();
            $table->string('vendor_name')->index()->nullable();
            $table->string('material_name')->index()->nullable();
            $table->string('material_type')->nullable();
            $table->string('project_number')->index()->nullable();
            $table->string('project_name')->index()->nullable();
            $table->string('project_manager')->index()->nullable();
            $table->string('audit_progress')->index()->nullable();
            $table->string('audit_document_number')->index()->nullable();
            $table->string('audit_company')->index()->nullable();
            $table->string('order_description')->index()->nullable();
            $table->string('contract_number')->index()->nullable();
            $table->string('audit_number')->index()->nullable();
            $table->string('cost')->nullable();
            $table->string('paid_cost')->nullable();
            $table->string('mis_cost')->nullable();
            $table->string('submit_cost')->nullable();
            $table->string('validation_cost')->nullable();

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
        Schema::dropIfExists('settlements');
    }
}
