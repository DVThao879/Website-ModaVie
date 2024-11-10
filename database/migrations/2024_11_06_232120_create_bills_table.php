<?php

use App\Models\User;
use App\Models\Voucher;
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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('set null');
            $table->boolean('is_guest')->default(true);
            $table->string('user_name');
            $table->string('user_email');
            $table->string('user_phone');
            $table->text('user_address');
            $table->decimal('total', 10, 2);
            $table->enum('payment_method', ['cod', 'online'])->default('cod');
            $table->string('status')->default(1);// 1 - Chờ xác nhận, 2 - Chờ lấy hàng, 3 - Đang giao hàng, 4 - Giao hàng thành công, 5 - Chờ hủy, 6 - Đã hủy
            $table->text('note')->nullable();
            $table->foreignIdFor(Voucher::class)->nullable()->constrained()->onDelete('set null');
            $table->string('order_code')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
