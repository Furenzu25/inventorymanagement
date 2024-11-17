<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('account_receivables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('preorder_id')->constrained();
            $table->decimal('monthly_payment', 10, 2);
            $table->decimal('total_paid', 10, 2)->default(0);
            $table->decimal('remaining_balance', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->integer('payment_months');
            $table->decimal('interest_rate', 5, 2);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('account_receivables');
    }
}; 