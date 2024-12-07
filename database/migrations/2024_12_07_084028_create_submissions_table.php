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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade'); // Relasi ke tabel assignments
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke tabel users (siswa)
            $table->string('file_path')->nullable(); // Menyimpan file yang diunggah
            $table->text('submission_content')->nullable(); // Konten jika tugas berupa artikel
            $table->enum('submission_type', ['document', 'link','article'])->default('document'); // Menyimpan tipe pengumpulan (document atau link)
            $table->string('submission_link')->nullable(); // Link yang dikumpulkan jika tugas adalah link
            $table->enum('status', ['submitted', 'graded'])->default('submitted'); // Status pengumpulan
            $table->timestamp('submitted_at')->nullable(); // Tanggal pengumpulan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
