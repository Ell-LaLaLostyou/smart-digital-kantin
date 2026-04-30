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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('canteen_id')->nullable()->constrained('canteens')->onDelete('set null');
        });

        $tables = ['menus', 'preorders', 'productions', 'food_wastes', 'sales', 'donations', 'simulations', 'dss_results'];
        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->foreignId('canteen_id')->nullable()->constrained('canteens')->onDelete('cascade');
            });
        }

        Schema::table('preorders', function (Blueprint $table) {
            $table->string('customer_name')->nullable()->after('user_id');
            $table->string('customer_phone')->nullable()->after('customer_name');
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('preorders', function (Blueprint $table) {
            $table->dropColumn(['customer_name', 'customer_phone']);
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });

        $tables = ['users', 'menus', 'preorders', 'productions', 'food_wastes', 'sales', 'donations', 'simulations', 'dss_results'];
        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropForeign(['canteen_id']);
                $table->dropColumn('canteen_id');
            });
        }
    }
};
