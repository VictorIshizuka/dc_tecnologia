<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('payment_type_id')->constrained('payment_types');
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
