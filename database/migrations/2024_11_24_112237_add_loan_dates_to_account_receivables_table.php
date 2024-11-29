<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('account_receivables', function (Blueprint $table) {
            $table->timestamp('loan_start_date')->nullable();
            $table->timestamp('loan_end_date')->nullable();
        });
    }

    public function down()
    {
        Schema::table('account_receivables', function (Blueprint $table) {
            $table->dropColumn(['loan_start_date', 'loan_end_date']);
        });
    }
};