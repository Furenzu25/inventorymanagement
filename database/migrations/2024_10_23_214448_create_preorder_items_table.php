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
        Schema::create('preorder_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('preorder_id')->constrained('preorders')->onDelete('cascade'); // Links to Preorder
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');   // Links to Product
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->after('product_id');
            $table->integer('quantity'); // The quantity of the product ordered
            $table->decimal('price', 10, 2); // The price of the product at the time of the preorder
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preorder_items');
    }
};
