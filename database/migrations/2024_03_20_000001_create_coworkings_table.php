<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('coworkings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('map_url')->nullable();
            $table->string('location');
            $table->decimal('price', 10, 2);
            $table->text('advantage')->nullable();
            $table->integer('capacity');
            $table->enum('status', ['occupé', 'disponible'])->default('disponible');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coworkings');
    }
}; 