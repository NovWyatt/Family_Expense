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
        Schema::create('shopping_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shopping_trip_id');
            $table->string('item_name'); // Tên món đồ
            $table->decimal('price', 15, 0); // Giá tiền
            $table->decimal('quantity', 8, 1)->default(1); // Số lượng (có thể là 0.5kg, 2.5kg...)
            $table->decimal('total_price', 15, 0); // Thành tiền (price * quantity)
            $table->text('notes')->nullable(); // Ghi chú cho món đồ này
            $table->timestamps();

            $table->foreign('shopping_trip_id')->references('id')->on('shopping_trips')->onDelete('cascade');
            $table->index('shopping_trip_id');
            $table->index('item_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_items');
    }
};
