<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('firstname', 32);
            $table->string('lastname', 32);
            $table->string('street');
            $table->string('street_number');
            $table->string('postcode', 8)->nullable();
            $table->string('country_code');
            $table->bigInteger('telephone');
            $table->string('voucher')->nullable();
            $table->float('total');
            $table->integer('generated_voucher')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
