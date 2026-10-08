<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crop_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');         // सब्जियां
            $table->string('name_en')->nullable(); // Vegetables
            $table->string('slug')->unique();
            $table->string('icon_class')->nullable(); // fa-solid fa-leaf
            $table->string('icon_bg')->nullable();   // #dcfce7
            $table->string('icon_color')->nullable(); // #15803d
            $table->string('link_url')->nullable();  // /vegetable-price
            $table->string('examples')->nullable();  // टमाटर, प्याज, आलू
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crop_categories');
    }
};
