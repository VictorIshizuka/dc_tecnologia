<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_order_id')->constrained('sales_orders');
            $table->integer('installment_number');
            $table->decimal('amount', 10, 2);
            $table->date('due_date');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
