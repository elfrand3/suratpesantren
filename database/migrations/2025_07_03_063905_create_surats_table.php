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
            $table->string('nomor_surat');
            $table->string('jenis_surat');
            $table->date('tanggal_surat');
            $table->string('status');
            $table->longText('content');
            $table->string('alasan')->nullable();
            $table->string('diagnosa')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->unsignedBigInteger('santri_id')->nullable();
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
