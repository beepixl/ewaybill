<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_performa', function (Blueprint $table) {
            $table->id();
           // $table->string('invNo', 100);
            $table->integer('customerId');
            $table->date('invDate');
            // $table->string('supplyType', 1);
            // $table->string('subSupplyType', 20);
            // $table->string('subSupplyDesc', 20)->nullable();;
            // $table->string('docType', 20)->nullable();
            // $table->string('docNo', 16)->nullable();
            // $table->date('docDate')->nullable();
            // $table->string('fromGstin', 15)->nullable();
            // $table->string('fromTrdName', 100)->nullable();
            // $table->string('fromAddr1', 120)->nullable();
            // $table->string('fromAddr2', 120)->nullable();
            // $table->string('fromPlace', 50)->nullable();
            // $table->integer('fromPincode')->default(0);
            // $table->integer('actFromStateCode')->default(0);
            // $table->integer('fromStateCode')->default(0);
            // $table->string('toGstin', 15)->nullable();
            // $table->string('toTrdName', 100);
            // $table->string('toAddr1', 120)->nullable();
            // $table->string('toAddr2', 120)->nullable();
            // $table->string('toPlace', 50)->nullable();
            // $table->integer('toPincode')->nullable();
            // $table->integer('actToStateCode')->nullable();
            // $table->integer('toStateCode')->nullable();
            // $table->integer('transactionType')->nullable();
            // $table->decimal('totalValue', 18, 2)->nullable();
            // $table->decimal('cgstValue', 18, 2)->nullable();
            // $table->decimal('sgstValue', 18, 2)->nullable();
            // $table->decimal('igstValue', 18, 2)->nullable();
            // $table->decimal('cessValue', 18, 2)->nullable();
            // $table->decimal('cessNonAdvolValue', 18, 2)->nullable();
            // $table->decimal('otherValue', 18, 2)->nullable();
            // $table->decimal('totInvValue', 18, 2);
            // $table->string('transMode')->nullable();
            // $table->string('transDistance')->nullable();
            // $table->string('transporterName', 100)->nullable();;
            // $table->string('transporterId')->nullable();;
            // $table->string('transDocNo', 15)->nullable();
            // $table->date('transDocDate')->nullable();;;
            // $table->string('vehicleNo', 15)->nullable();;;
            // $table->string('vehicleType')->nullable();
            // $table->string('status')->default(0)->comment('0 = pending,1 = paid,2 = partial')->nullable();
            // $table->string('ewayBillNo',100)->nullable();
            // $table->string('ewayBillDate',100)->nullable();
            // $table->string('validUpto',100)->nullable();
            // $table->text('alert')->nullable();
            // $table->integer('bankId')->nullable();
            // $table->string('incoterms',250)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_performa');
    }
};
