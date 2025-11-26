<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('surat_keluars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_agenda');
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->string('tujuan_surat');
            $table->string('perihal');
            $table->foreignId('kategori_id')->constrained('kategori_surats');
            $table->text('isi_ringkas')->nullable();
            $table->string('lampiran_file')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluars');
    }
};
