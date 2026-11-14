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
        Schema::table('products', function (Blueprint $table) {
            $table->string('image')->nullable()->after('icon');
            $table->boolean('is_active')->default(true)->after('stock');
            $table->boolean('is_featured')->default(false)->after('is_active');
            $table->integer('display_order')->default(0)->after('is_featured');
            $table->integer('discount_percent')->nullable()->after('discount');
            $table->boolean('discount_active')->default(true)->after('discount_percent');
            $table->timestamp('discount_expires_at')->nullable()->after('discount_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'image',
                'is_active',
                'is_featured',
                'display_order',
                'discount_percent',
                'discount_active',
                'discount_expires_at',
            ]);
        });
    }
};
