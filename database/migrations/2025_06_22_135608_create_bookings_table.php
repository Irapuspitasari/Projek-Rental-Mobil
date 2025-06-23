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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('address')->nullable();
            $table->text('city')->nullable();
            $table->string('zip')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('duration_days');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->enum('region', ['Jateng', 'DIY', 'Luar Provinsi']);
            $table->enum('driver_option', ['With Driver', 'Without Driver']);
            $table->enum('status', ['Pending', 'Confirmed', 'On Rent', 'Completed', 'Cancelled'])->default('Pending');
            $table->decimal('base_price', 12, 2);
            $table->decimal('driver_fee', 12, 2)->default(0);
            $table->decimal('out_of_region_fee', 12, 2)->default(0);
            $table->decimal('overtime_fee', 12, 2)->default(0);
            $table->decimal('total_price', 12, 2);
            $table->text('notes')->nullable();
            $table->dateTime('actual_end_date')->nullable();
            $table->boolean('is_overtime')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
