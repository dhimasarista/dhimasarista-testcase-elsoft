<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_account_groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("name");
            $table->uuid("item_groups_id");
            $table->foreign("item_groups_id")->references("id")->on("item_groups");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_account_groups');
    }
};
