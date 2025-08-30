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
        Schema::create('shopping_trips', function (Blueprint $table) {
            $table->id();
            $table->date('shopping_date'); // Ngày đi chợ
            $table->decimal('total_amount', 15, 0)->default(0); // Tổng tiền (sẽ tự động tính từ shopping_items)
            $table->text('notes')->nullable(); // Ghi chú cho lần đi chợ này
            $table->integer('items_count')->default(0); // Số lượng món đồ (để dễ query)
            $table->timestamps();

            $table->index('shopping_date');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_trips');
    }
};
