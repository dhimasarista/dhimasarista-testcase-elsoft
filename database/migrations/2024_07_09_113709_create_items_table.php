<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('company_id');
            $table->uuid('item_type_id');
            $table->string('code')->nullable();
            $table->string('label');
            $table->uuid('item_group_id')->nullable();
            $table->uuid('item_account_group_id')->nullable();
            $table->uuid('item_unit_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('item_group_id')->references('id')->on('item_groups');
            $table->foreign('item_account_group_id')->references('id')->on('item_account_groups');
            $table->foreign('item_unit_id')->references('id')->on('item_units');
        });

    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
}
