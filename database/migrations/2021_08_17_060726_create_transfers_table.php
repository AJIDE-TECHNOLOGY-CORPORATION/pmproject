<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


            $table->unsignedBigInteger('from_id')->unsigned();
            $table->foreign('from_id')->references('id')->on('banks')->onDelete('cascade');

            $table->unsignedBigInteger('to_id')->unsigned();
            $table->foreign('to_id')->references('id')->on('banks')->onDelete('cascade');

            $table->double('amount')->default(0);
            $table->date('date');
            $table->text('reference')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('transfers');
    }
}
