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
        Schema::create('mata_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('materis', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('content')->nullable(); // Untuk menyimpan isi materi jika tipe adalah artikel
            $table->enum('type', ['document', 'video', 'link', 'ppt']); // Tambahkan tipe lain jika perlu
            $table->string('url')->nullable(); // Untuk URL atau path file
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade'); // Relasi dengan tabel users
            $table->unsignedBigInteger('mata_pelajaran_id');
            $table->foreign('mata_pelajaran_id')->references('id')->on('mata_pelajaran')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materis');
        Schema::dropIfExists('mata_pelajaran');
    }
};
