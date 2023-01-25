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
        Schema::create('product_masters', function (Blueprint $table) {
            $table->id();
            $table->string('productName',100)->nullable();
            $table->decimal('productPrice',10,2)->default(0.00);
            $table->string('productDesc',100)->nullable();
            $table->integer('hsnCode')->default(0);
            $table->integer('cgst')->default(0);
            $table->integer('sgst')->default(0);
            $table->integer('igst')->default(0);
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
        Schema::dropIfExists('product_masters');
    }
};
