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
            $table->id()->primary();
            $table->string('order_code')->unique();
            $table->integer('quantity');
            $table->string('customer_id')->index();
            $table->string('service_id')->index();
            $table->string('payment_method');
            $table->string('payment_status');
            $table->string('status');
            $table->string('total');
            $table->string('payment');
            $table->string('change');
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
