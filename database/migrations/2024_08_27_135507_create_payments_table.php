<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_receivable_id')->constrained();
            $table->decimal('amount_paid', 10, 2);
            $table->date('payment_date');
            $table->decimal('due_amount', 10, 2);
            $table->decimal('remaining_balance', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}; 