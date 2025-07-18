<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->collation('utf8mb4_unicode_ci');
            $table->string('image', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->tinyInteger('status')->default(1); // 1: Hiển thị, 0: Ẩn
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slides');
    }
};
