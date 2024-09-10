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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('preorder_id')->constrained()->onDelete('cascade'); // Ensure preorder_id is properly defined
            $table->foreignId('customer_id')->constrained()->onDelete('cascade'); // Ensure customer_id is properly defined
            $table->foreignId('sale_id')->constrained()->onDelete('cascade'); // Add sale_id as a foreign key
            $table->decimal('total_paid', 8, 2);
            $table->date('payment_date');
            $table->decimal('due_amount', 8, 2);
            $table->timestamps();

            $table->index('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
