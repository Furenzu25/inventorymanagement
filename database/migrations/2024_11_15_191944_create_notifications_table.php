<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // preorder, ar_due, inventory, etc.
            $table->string('title');
            $table->text('message');
            $table->string('status')->default('unread');
            $table->json('data')->nullable(); // For additional data
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropTable('notifications');
    }
};