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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('toGstin',15);
            $table->string('toTrdName',100);
            $table->string('toAddr1',120);
            $table->string('toAddr2',120);
            $table->string('toPlace',50);
            $table->integer('toPincode');
            $table->integer('actToStateCode');
            $table->integer('toStateCode');
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
};
