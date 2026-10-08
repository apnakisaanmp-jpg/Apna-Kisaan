<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Contact form submissions → leads
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 15);
            $table->string('district')->nullable();
            $table->string('subject')->nullable();
            $table->string('vegetable')->nullable();
            $table->text('message');
            $table->string('status')->default('new'); // new, contacted, follow_up, resolved, closed
            $table->text('admin_notes')->nullable();
            $table->string('source_page')->default('contact'); // contact, home, about etc.
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('contacted_at')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['status', 'created_at']);
            $table->index('phone');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
