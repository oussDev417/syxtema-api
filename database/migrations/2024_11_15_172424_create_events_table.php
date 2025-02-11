<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Helpers\Constant;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_category_id')->constrained('event_categories')->onDelete('cascade'); // Clé étrangère vers event_categories
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade'); // Clé étrangère vers countries
            $table->foreignId('departement_id')->constrained('departements')->onDelete('cascade'); // Clé étrangère vers departements
            $table->string('title');
            $table->tinyInteger('type')->default(1);
            $table->string('slug')->unique(); // Slug de l'événement
            // $table->string('thumbnail')->nullable(); // Miniature de l'événement
            $table->dateTime('start_date'); // Date de début
            $table->dateTime('end_date'); // Date de fin
            $table->string('location'); // Lieu de l'événement
            $table->decimal('price', 12, 2)->default(0);
            $table->integer('number_of_ticket')->default(0);
            $table->integer('number_of_ticket_left')->default(0); // Nombre de tickets restants
            $table->text('description')->nullable(); // Description de l'événement
            $table->unsignedBigInteger('created_by');
            $table->tinyInteger('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
