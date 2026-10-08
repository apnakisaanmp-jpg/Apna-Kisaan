<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // Hindi: दमोह
            $table->string('name_en');       // English: Damoh
            $table->string('slug')->unique();
            $table->string('region')->nullable(); // विंध्य क्षेत्र, मालवा, महाकौशल, चंबल
            $table->string('gradient_class')->nullable(); // CSS gradient class
            $table->text('description')->nullable();
            $table->text('market_info')->nullable();
            $table->string('featured_image')->nullable();
            $table->boolean('is_featured')->default(false); // 12 featured districts
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->index(['is_active', 'sort_order']);
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('districts');
    }
};
