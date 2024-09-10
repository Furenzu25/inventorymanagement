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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('preorder_id')->constrained()->onDelete('cascade'); // Ensure preorder_id is properly defined
            $table->foreignId('customer_id')->constrained()->onDelete('cascade'); // Ensure customer_id is properly defined
            $table->decimal('monthly_payment', 8, 2);
            $table->timestamps();

            $table->index('preorder_id');
            $table->index('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
