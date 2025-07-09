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
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->string('jenis_surat');
            $table->date('tanggal_surat');
            $table->string('perihal');
            $table->string('status');
            $table->string('template_surat')->nullable();
            $table->string('nis');
            $table->string('nama_santri');
            $table->string('alasan')->nullable();
            $table->string('diagnosa')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->text('content')->nullable();
            $table->unsignedBigInteger('santri_id')->nullable();
            $table->string('file_surat')->nullable();
            $table->foreign('santri_id')->references('id')->on('santris')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
