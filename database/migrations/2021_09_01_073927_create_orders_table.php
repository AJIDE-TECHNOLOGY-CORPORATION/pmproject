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

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->text('shipping_address')->nullable();
            $table->text('billing_address')->nullable();

            $table->double('sub_total')->default(0);
            $table->string('tax_name')->default(0);
            $table->string('tax_percentage')->default(0);
            $table->double('tax_amount')->default(0);
            $table->double('total')->default(0);
            $table->date('order_date')->nullable();
            $table->string('order_number')->nullable();
            $table->integer('order_status')->default(0);
            $table->integer('invoice_status')->default(0);

            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->foreign('invoice_id')->references('id')->on('invoices');

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
