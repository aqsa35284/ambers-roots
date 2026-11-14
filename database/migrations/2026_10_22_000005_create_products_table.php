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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('category')->default('hair-oil');
            $table->string('category_name')->default('Hair Care');
            $table->string('volume')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->string('discount')->nullable();
            $table->decimal('rating', 3, 1)->default(5.0);
            $table->integer('reviews_count')->default(1);
            $table->string('badge')->nullable();
            $table->string('icon')->default('fa-bottle-droplet');
            $table->text('short_desc')->nullable();
            $table->text('ingredients')->nullable();
            $table->text('how_to_use')->nullable();
            $table->json('benefits')->nullable();
            $table->integer('stock')->default(100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
