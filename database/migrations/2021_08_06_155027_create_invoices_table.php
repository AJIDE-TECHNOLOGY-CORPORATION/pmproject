<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
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

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->text('shipping_address')->nullable();
            $table->text('billing_address')->nullable();

            $table->double('sub_total')->default(0);
            $table->string('tax_name')->default(0);
            $table->string('tax_percentage')->default(0);
            $table->double('tax_amount')->default(0);
            $table->double('total')->default(0);

            $table->double('paid')->default(0);

            $table->date('invoice_date')->nullable();

            $table->string('invoice_number')->nullable();

            $table->integer('invoice_status')->default(0);

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
}
