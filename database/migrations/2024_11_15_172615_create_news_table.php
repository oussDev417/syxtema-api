<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('news_category_id')->nullable();
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade'); // Clé étrangère vers countries
            $table->string('title');
            $table->string('slug');
            $table->longText('description');
            $table->integer('image')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
