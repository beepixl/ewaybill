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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('fromGstin',15)->nullable();
            $table->string('fromTrdName',100)->nullable();
            $table->string('fromAddr1',120)->nullable();
            $table->string('fromAddr2',120)->nullable();
            $table->string('fromPlace',50)->nullable();
            $table->integer('fromPincode')->default(0);
            $table->integer('actFromStateCode')->default(0);
            $table->integer('fromStateCode')->default(0);
            $table->string('invPrefix',10)->nullable();
            $table->integer('invNoStart')->default(0);
            $table->string('logoPath',20)->nullable();
            $table->string('appName',100)->nullable();
            $table->string('timezone',15)->default('UTC');
            $table->string('pColor',15)->default('#6777ef');
            $table->string('sColor',15)->default('#fff');
            $table->enum('appEnv',['production','staging','local'])->default('local');
            $table->boolean('appDebug')->default(0)->comment('0 = debug-false , 1 = debug-true');
            $table->enum('dbConn',['mysql','mysqlLocal','sqlsrv'])->default('mysqlLocal');
            $table->enum('storageDisk',['local','public','s3'])->default('public');
            $table->string('mailHost',10)->nullable();
            $table->integer('mailPort')->default(0);
            $table->enum('mailEnc',['tls','ssl'])->default('tls');
            $table->string('mailUnm',20)->nullable();
            $table->string('mailPwd',20)->nullable();
            $table->string('mailFrom',20)->nullable();
            $table->string('mailName',20)->nullable();
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
        Schema::dropIfExists('settings');
    }
};
