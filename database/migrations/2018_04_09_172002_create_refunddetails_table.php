<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefunddetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunddetails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('audit_document_number')->index()->nullable();
            $table->string('project_number')->index()->nullable();
            $table->string('project_name')->index()->nullable();
            $table->string('construction_enterprise')->index()->nullable();
            $table->string('material_name')->index()->nullable();
            $table->string('unit_price')->nullable();
            $table->string('reduction_quantity')->nullable();
            $table->string('subtraction_cost')->nullable();
            $table->string('scm_refund_number')->index()->nullable();
            $table->string('refund_apply_amount')->nullable();
            $table->string('refund_amount')->nullable();
            $table->string('erp_refund_number')->index()->nullable();
            $table->string('erp_unrefund_reason')->index()->nullable();
            $table->string('scm_receive_number')->nullable();
            $table->string('scm_receive_amount')->index()->nullable();
            $table->string('refund_cost')->nullable();
            $table->string('cash_refund')->nullable();
            $table->string('unrefund_cost')->nullable();
            $table->string('iscomplete_refund')->nullable();
            $table->string('unrefund_reason')->index()->nullable();
            $table->string('remarks')->index()->nullable();
            $table->string('kkk2')->index()->nullable();

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
        Schema::dropIfExists('refunddetails');
    }
}
