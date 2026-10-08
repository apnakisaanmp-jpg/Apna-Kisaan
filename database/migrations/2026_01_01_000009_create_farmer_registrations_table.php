<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('farmer_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('farmer'); // farmer, buyer
            // Common fields
            $table->string('name');
            $table->string('mobile', 15);
            // Farmer fields
            $table->string('district')->nullable();
            $table->string('village')->nullable();
            $table->string('main_crop')->nullable();
            $table->decimal('farm_area', 8, 2)->nullable(); // in acres
            // Buyer fields
            $table->string('business_type')->nullable(); // थोक व्यापारी, रिटेलर, निर्यातकर्ता
            $table->string('city')->nullable();
            $table->string('required_crop')->nullable();
            $table->decimal('required_quantity', 10, 2)->nullable(); // in quintals
            // Admin
            $table->string('status')->default('new'); // new, contacted, active, inactive
            $table->text('admin_notes')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['type', 'status', 'created_at']);
            $table->index('mobile');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('farmer_registrations');
    }
};
