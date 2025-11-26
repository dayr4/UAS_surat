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
        Schema::create('agenda_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->foreignId('jenis_agenda_id')->constrained('jenis_agendas');
            $table->datetime('waktu_mulai');
            $table->datetime('waktu_selesai');
            $table->string('tempat');
            $table->text('keterangan')->nullable();
            $table->string('status')->default('aktif');
            $table->foreignId('surat_masuk_id')->nullable()->constrained('surat_masuks');
            $table->foreignId('surat_keluar_id')->nullable()->constrained('surat_keluars');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agenda_kegiatans');
    }
};
