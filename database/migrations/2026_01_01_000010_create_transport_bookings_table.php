<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transport_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
            $table->string('pickup_location');
            $table->string('delivery_location');
            $table->string('vehicle_type'); // truck, pickup, cold
            $table->string('crop_name');
            $table->decimal('quantity', 10, 2); // quintals
            $table->date('preferred_date');
            $table->string('mobile', 15);
            $table->text('notes')->nullable();
            $table->string('status')->default('pending'); // pending, confirmed, in_transit, delivered, cancelled
            $table->text('admin_notes')->nullable();
            $table->decimal('estimated_cost', 10, 2)->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_phone')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['status', 'preferred_date']);
            $table->index('mobile');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transport_bookings');
    }
};
