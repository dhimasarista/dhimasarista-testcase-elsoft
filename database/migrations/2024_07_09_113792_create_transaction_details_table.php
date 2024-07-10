<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->uuid('item_id');
            $table->foreign("item_id")->references("id")->on("items");
            $table->text('note')->nullable();
            $table->integer('quantity');
            $table->uuid("item_unit_id");
            $table->foreign("item_unit_id")->references("id")->on("item_units");
            // $table->decimal('price', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaction_details');
    }
}
