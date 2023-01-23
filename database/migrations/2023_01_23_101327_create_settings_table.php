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
            $table->string('fromGstin',15);
            $table->string('fromTrdName',100);
            $table->string('fromAddr1',120);
            $table->string('fromAddr2',120);
            $table->string('fromPlace',50);
            $table->integer('fromPincode');
            $table->integer('actFromStateCode');
            $table->integer('fromStateCode');
            $table->string('invPrefix',10);
            $table->integer('invNoStart');
            $table->string('logoPath',20);
            $table->string('appName',100);
            $table->string('timezone',15)->default('UTC');
            $table->string('pColor',15)->default('#6777ef');
            $table->string('sColor',15)->default('#fff');
            $table->enum('appEnv',['production','staging','local'])->default('local');
            $table->boolean('appDebug')->default(0)->comment('0 = debug-false , 1 = debug-true');
            $table->enum('dbConn',['mysql','mysqlLocal','sqlsrv'])->default('mysqlLocal');
            $table->enum('storageDisk',['local','public','s3'])->default('public');
            $table->string('mailHost',10);
            $table->integer('mailPort');
            $table->enum('mailEnc',['tls','ssl'])->default('tls');
            $table->string('mailUnm',20);
            $table->string('mailPwd',20);
            $table->string('mailFrom',20);
            $table->string('mailName',20);
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
