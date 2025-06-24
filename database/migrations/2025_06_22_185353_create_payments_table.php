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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->string('slug')->unique();
            $table->enum('method', ['Transfer', 'Cash']);
            $table->enum('status', ['Pending', 'Paid', 'Failed', 'Expired']);
            $table->decimal('amount', 12, 2);
            $table->string('payment_url')->nullable();
            $table->string('payment_reference')->nullable()->index();
            $table->dateTime('payment_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
