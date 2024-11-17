<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_receivable_id')->constrained('account_receivables')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('preorder_id')->constrained()->onDelete('cascade');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('interest_earned', 10, 2);
            $table->date('completion_date');
            $table->string('payment_method');
            $table->string('status')->default('completed');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index('account_receivable_id');
            $table->index('customer_id');
            $table->index('preorder_id');
            $table->index('completion_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
}; 