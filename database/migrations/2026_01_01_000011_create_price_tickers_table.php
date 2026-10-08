<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Homepage price ticker items - admin manageable
        Schema::create('price_tickers', function (Blueprint $table) {
            $table->id();
            $table->string('commodity_name');    // टमाटर
            $table->string('commodity_en')->nullable(); // Tomato
            $table->string('icon_class')->nullable(); // fa-solid fa-leaf
            $table->decimal('price', 10, 2)->nullable();
            $table->string('unit')->default('क्वि.'); // क्वि., किग्रा
            $table->string('trend')->default('same'); // up, down, same
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_tickers');
    }
};
