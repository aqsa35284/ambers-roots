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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone');
            $table->string('city');
            $table->text('shipping_address');
            $table->string('payment_method')->default('COD'); // COD, JazzCash, EasyPaisa, Bank Transfer
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_fee', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('status')->default('Pending'); // Pending, Processing, Dispatched, Delivered, Cancelled
            $table->string('courier_service')->nullable(); // TCS, Leopards, Trax, PostEx
            $table->string('tracking_number')->nullable();
            $table->json('items'); // JSON array of products ordered
            $table->foreignId('assigned_employee_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
