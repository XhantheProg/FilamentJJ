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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->nullable()
                ->constrained() // references 'id' on 'products' table
                ->nullOnDelete(); // set to null if the referenced product is deleted
            
            $table->foreignId('warehouse_id')
                ->nullable()
                ->constrained() // references 'id' on 'products' table
                ->nullOnDelete(); // set to null if the referenced product is deleted
            
            $table->integer('quantity')->default(0); // quantity of the product in the warehouse

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
