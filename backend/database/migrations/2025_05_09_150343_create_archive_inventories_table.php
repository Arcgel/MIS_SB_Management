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
        Schema::create('archive_inventories', function (Blueprint $table) {
            $table->id();
            $table->integer('inventoryID')->constrained('inventories')->onDelete('cascade');
            $table->string('itemName')->references('itemName')->on('inventories');
            $table->string('itemUnit')->references('itemUnit')->on('inventories');
            $table->integer('inventoryStock')->references('inventoryStock')->on('inventories');
            $table->date('inventoryDateAdded')->references('inventoryDateAdded')->on('inventories');
            $table->date('inventoryExpirationDate')->references('inventoryExpirationDate')->on('inventories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archive_inventories');
    }
};
