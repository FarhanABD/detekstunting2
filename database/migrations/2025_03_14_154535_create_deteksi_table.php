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
        Schema::create('riwayat_deteksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); 
            $table->string('nama_lengkap');
            $table->date('tanggal_lahir');
            $table->integer('usia');
            $table->enum('kategori_usia',['Berisiko', 'Tidak berisiko'])->default('Tidak berisiko');
            $table->date('hpht');
            $table->decimal('lila');
            $table->string('kategori_lila');
            $table->decimal('tb_ibu');
            $table->string('kategori_tb');
            $table->integer('jumlah_anak');
            $table->integer('kategori_anak');
            $table->integer('jumlah_ttd');
            $table->string('kategori_ttd');
            $table->integer('jumlah_anc');
            $table->string('kategori_anc');
            $table->string('tekanan_darah');
            $table->string('kategori_td');
            $table->decimal('hb');
            $table->string('kategori_hb');
            $table->text('hasil_deteksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_deteksi');
    }
};