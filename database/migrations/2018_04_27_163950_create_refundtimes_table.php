<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundtimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refundtimes', function (Blueprint $table) {
            $table->increments('id');        
            $table->string('实物退库')->nullable();
            $table->string('现金退库')->nullable();
            $table->string('施工单位直接用于其它工程（有退库领用手续）')->nullable();
            $table->string('施工单位直接用于其它工程（无退库领用手续）')->nullable();
            $table->string('未退库金额')->nullable();
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
        Schema::dropIfExists('refundtimes');
    }
}
