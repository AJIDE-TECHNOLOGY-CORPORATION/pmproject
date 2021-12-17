<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimates', function (Blueprint $table) {
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

            $table->date('estimate_date')->nullable();
            $table->date('estimate_due_date')->nullable();
            $table->string('estimate_number',15,2)->nullable();

            $table->integer('estimate_status')->default(0);

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
        Schema::dropIfExists('estimates');
    }
}
