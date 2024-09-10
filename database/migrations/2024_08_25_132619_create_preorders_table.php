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
        Schema::create('preorders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Ensure product_name is properly defined
            $table->foreignId('customer_id')->constrained()->onDelete('cascade'); // Ensure customer_id is properly defined
            $table->integer('loan_duration');
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->string('bought_location');
            $table->enum('status', ['ongoing', 'ready'])->default('ongoing'); // Add status column
            $table->string('payment_method');
            $table->date('order_date');
            $table->timestamps();

        
            $table->index('product_id');
            $table->index('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preorders');
    }
};
