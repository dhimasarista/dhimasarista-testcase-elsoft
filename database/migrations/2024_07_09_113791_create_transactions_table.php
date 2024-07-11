<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('code');
            $table->uuid('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->text('note')->nullable();
            $table->integer("status_id")->nullable();
            $table->foreign("status_id")->references("id")->on("statuses");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
