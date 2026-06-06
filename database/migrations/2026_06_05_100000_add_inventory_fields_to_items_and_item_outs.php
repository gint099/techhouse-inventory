<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->unsignedInteger('minimum_stock')->default(5)->after('stock');
            $table->string('rack_location')->nullable()->after('minimum_stock');
        });

        Schema::table('item_outs', function (Blueprint $table) {
            $table->string('destination')->nullable()->after('quantity');
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['minimum_stock', 'rack_location']);
        });

        Schema::table('item_outs', function (Blueprint $table) {
            $table->dropColumn('destination');
        });
    }
};
