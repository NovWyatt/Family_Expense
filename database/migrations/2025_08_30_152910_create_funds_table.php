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
        Schema::create('funds', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 15, 2); // Số tiền (có thể âm nếu rút quỹ)
            $table->enum('type', ['add', 'subtract']); // add: nạp tiền, subtract: trừ tiền
            $table->string('description')->nullable(); // Mô tả (VD: "Nạp quỹ đầu tháng", "Đi chợ ngày 15/1")
            $table->unsignedBigInteger('shopping_trip_id')->nullable(); // Liên kết với lần đi chợ (nếu là trừ tiền)
            $table->timestamps();

            $table->foreign('shopping_trip_id')->references('id')->on('shopping_trips')->onDelete('cascade');
            $table->index('type');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funds');
    }
};
