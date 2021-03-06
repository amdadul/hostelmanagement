<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('building_id')->nullable();
            $table->foreign('building_id')->references('id')->on('buildings');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone_no');
            $table->text('address')->nullable();
            $table->string('nid')->nullable();
            $table->string('fathers_name')->nullable();
            $table->string('fathers_phone')->nullable();
            $table->string('fathers_profession')->nullable();
            $table->string('mothers_name')->nullable();
            $table->string('mothers_phone')->nullable();
            $table->string('reason_to_stay')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_phone_no')->nullable();
            $table->string('relation_with_guardian')->nullable();
            $table->string('religion')->nullable();
            $table->string('marital_status');
            $table->string('gender');
            $table->string('profession');
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('customers');
    }
}
