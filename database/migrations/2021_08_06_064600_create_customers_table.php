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
            $table->string('currency')->nullable();
            $table->string('display_name');
            $table->string('contact_name')->nullable();
            $table->string('phone');
            $table->string('website')->nullable();

            $table->text('billing_address_name')->nullable();
            $table->text('billing_address_country')->nullable();
            $table->text('billing_address_state')->nullable();
            $table->text('billing_address_city')->nullable();
            $table->text('billing_address_phone')->nullable();
            $table->text('billing_address_zip')->nullable();
            $table->text('billing_address1')->nullable();
            $table->text('billing_address2')->nullable();

            $table->text('shipping_address_name')->nullable();
            $table->text('shipping_address_country')->nullable();
            $table->text('shipping_address_state')->nullable();
            $table->text('shipping_address_city')->nullable();
            $table->text('shipping_address_phone')->nullable();
            $table->text('shipping_address_zip')->nullable();
            $table->text('shipping_address1')->nullable();
            $table->text('shipping_address2')->nullable();
            $table->double('amount_due')->default(0);


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
