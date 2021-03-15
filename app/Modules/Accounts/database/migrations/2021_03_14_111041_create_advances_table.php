<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('max_sl_no');
            $table->string('voucher_no')->nullable();
            $table->unsignedBigInteger('seat_id');
            $table->foreign('seat_id')->references('id')->on('seats');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->unsignedBigInteger('money_receipt_id')->nullable();
            $table->foreign('money_receipt_id')->references('id')->on('money_receipts');
            $table->date('date');
            $table->double('amount')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
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
        Schema::dropIfExists('advances');
    }
}
