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
            //có name, description, image, price, category_id, status,stock,views,created_at,updated_at
            $table->string('name');
            $table->text('description');
            $table->string('image')->nullable();
            $table->decimal('price', 15, 2);
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('status')->default(1);
            $table->integer('stock')->default(0);
            $table->integer('views')->default(0);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
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
