<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('preorders', function (Blueprint $table) {
            $table->string('payment_method')->default('cash');
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
        });
    }

    public function down(): void
    {
        Schema::table('preorders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_status']);
        });
    }
};
