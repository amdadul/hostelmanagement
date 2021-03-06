<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('max_sl_no');
            $table->string('voucher_no')->nullable();
            $table->unsignedBigInteger('assets_id');
            $table->foreign('assets_id')->references('id')->on('assets');
            $table->string('type');
            $table->double('credit_amount')->nullable();
            $table->double('debit_amount')->nullable();
            $table->date('date');
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
        Schema::dropIfExists('assets_histories');
    }
}
