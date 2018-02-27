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
            $table->string('vendor_name')->index();
            $table->string('material_name')->index();
            $table->string('material_type');
            $table->string('project_number')->index();
            $table->string('project_name')->index();
            $table->string('project_manager')->index();
            $table->string('audit_progress')->index();
            $table->string('audit_document_number')->index();
            $table->string('audit_company')->index();
            $table->string('order_description')->index();
            $table->string('contract_number')->index();
            $table->string('audit_number')->index();
            $table->string('cost');
            $table->string('paid_cost');
            $table->string('mis_cost');
            $table->string('submit_cost');
            $table->string('validation_cost');

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
