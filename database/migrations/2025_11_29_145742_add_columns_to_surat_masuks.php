<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('surat_masuks', function (Blueprint $table) {

            if (!Schema::hasColumn('surat_masuks', 'kategori_id')) {
                $table->unsignedBigInteger('kategori_id')->nullable()->after('perihal');
            }

            if (!Schema::hasColumn('surat_masuks', 'isi_ringkas')) {
                $table->text('isi_ringkas')->nullable()->after('kategori_id');
            }

            if (!Schema::hasColumn('surat_masuks', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('lampiran_file');
            }
        });
    }

    public function down()
    {
        Schema::table('surat_masuks', function (Blueprint $table) {
            $table->dropColumn(['kategori_id', 'isi_ringkas', 'created_by']);
        });
    }
};
