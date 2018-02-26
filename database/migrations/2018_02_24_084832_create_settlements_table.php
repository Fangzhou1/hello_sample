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
        Schema::create('Settlements', function (Blueprint $table) {
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
            $table->decimal('cost',15, 4);
            $table->decimal('paid_cost',15, 4);
            $table->decimal('mis_cost',15, 4);
            $table->decimal('submit_cost',15, 4);
            $table->decimal('validation_cost',15, 4);

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
        Schema::dropIfExists('Settlements');
    }
}
