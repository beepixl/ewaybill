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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invNo',100);
            $table->string('supplyType',1);
            $table->string('subSupplyType',20);
            $table->string('subSupplyDesc',20);
            $table->string('docType',20);
            $table->string('docNo',16);
            $table->date('docDate');
            $table->integer('transactionType')->nullable();
            $table->decimal('totalValue',18,2)->nullable();
            $table->decimal('cgstValue',18,2);
            $table->decimal('sgstValue',18,2);
            $table->decimal('igstValue',18,2);
            $table->decimal('cessValue',18,2)->nullable();
            $table->decimal('cessNonAdvolValue',18,2)->nullable();
            $table->decimal('otherValue',18,2)->nullable();
            $table->decimal('totInvValue',18,2);
            $table->string('transMode');
            $table->string('transDistance')->nullable();
            $table->string('transporterName',100);
            $table->string('transporterId');
            $table->string('transDocNo',15)->nullable();
            $table->date('transDocDate');
            $table->string('vehicleNo',15);
            $table->string('vehicleType')->nullable();
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
        Schema::dropIfExists('invoices');
    }
};
