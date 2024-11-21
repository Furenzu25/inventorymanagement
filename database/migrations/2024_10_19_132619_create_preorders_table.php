<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('preorders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->integer('loan_duration');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('monthly_payment', 10, 2);
            $table->decimal('interest_rate', 5, 2)->default(5.00);
            $table->string('bought_location');
            $table->string('status', 20)->default('ongoing');
            $table->string('payment_method');
            $table->date('order_date');
            $table->text('disapproval_reason')->nullable();
            $table->timestamps();
            $table->index('customer_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preorders');
    }
};