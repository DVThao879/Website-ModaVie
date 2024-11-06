<?php

use App\Models\User;
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
            $table->id(); // Primary key
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_name'); 
            $table->string('user_email');
            $table->string('user_phone');
            $table->text('user_address');
            $table->decimal('total', 10, 2);
            $table->string('payment_method')->default('cod');
            $table->string('status')->default('Chờ xác nhận');
            $table->timestamp('date')->nullable();
            $table->text('note')->nullable();
            $table->decimal('discount', 10, 2)->nullable();
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
