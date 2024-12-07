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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('assignments_file')->nullable(); // To store file path
            $table->text('assignments_content')->nullable();
            $table->enum('assignments_type', ['document', 'link', 'article']); // Tambahkan tipe lain jika perlu
            $table->string('assignments_link')->nullable(); // Untuk URL atau path file
            $table->foreignId('materi_id')->constrained('materis')->onDelete('cascade'); // Relate to 'materis' table
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
