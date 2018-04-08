<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('audit_report_name')->index()->nullable();
            $table->string('professional_room')->index()->nullable();
            $table->string('project_manager')->index()->nullable();
            $table->string('project_number')->nullable();
            $table->string('publish_date')->index()->nullable();
            $table->string('audit_document_number')->index()->nullable();
            $table->string('audit_type')->index()->nullable();
            $table->string('project_type')->nullable();
            $table->string('audit_company')->index()->nullable();
            $table->string('submit_cost')->index()->nullable();
            $table->string('validation_cost')->index()->nullable();
            $table->string('subtraction_cost')->index()->nullable();
            $table->string('subtraction_rate')->index()->nullable();
            $table->string('mterials_audit')->index()->nullable();
            $table->string('construction_should_refund')->nullable();
            $table->string('thing_refund')->nullable();
            $table->string('cash_refund')->nullable();
            $table->string('direct_yes')->nullable();
            $table->string('direct_no')->nullable();
            $table->string('unrefund_cost')->nullable();
            $table->string('reason')->nullable();
            $table->string('Remarks')->nullable();
            $table->string('kkk')->nullable();
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
        Schema::dropIfExists('refunds');
    }
}
