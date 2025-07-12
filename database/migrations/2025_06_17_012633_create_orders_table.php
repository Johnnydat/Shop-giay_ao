<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('order_code', 255)->collation('utf8mb4_unicode_ci')->unique();
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('status', 255)->collation('utf8mb4_unicode_ci')->default('pending');
            $table->string('payment_method', 255)->collation('utf8mb4_unicode_ci');
            $table->text('shipping_address')->collation('utf8mb4_unicode_ci');
            $table->text('billing_address')->collation('utf8mb4_unicode_ci');
            $table->string('customer_name', 255)->collation('utf8mb4_unicode_ci');
            $table->string('customer_email', 255)->collation('utf8mb4_unicode_ci');
            $table->string('customer_phone', 255)->collation('utf8mb4_unicode_ci');
            $table->text('notes')->collation('utf8mb4_unicode_ci')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
