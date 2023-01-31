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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('invID');
            $table->unsignedBigInteger('productId');
            $table->string('productName', 100);
            $table->string('productDesc', 100)->nullable();
            $table->string('productNotes', 100)->nullable();
            $table->integer('hsnCode')->nullable();
            $table->integer('quantity');
            $table->string('qtyUnit',3)->nullable();
            $table->decimal('taxableAmount',18,2);
            $table->decimal('sgstRate',18,2)->nullable();
            $table->decimal('cgstRate',18,2)->nullable();
            $table->decimal('igstRate',18,2)->nullable();
            $table->decimal('cessRate',18,2)->nullable();
            $table->decimal('cessNonadvol',18,2)->nullable();
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
        Schema::dropIfExists('products');
    }
};
