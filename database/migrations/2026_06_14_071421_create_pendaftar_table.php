<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan Pembuatan Tabel Pendaftar
     */
    public function up(): void
    {
        Schema::create('pendaftar', function (Blueprint $table) {
            $table->id(); // Primary Key auto-increment biasa (bukan UUID Supabase lagi)
            $table->unsignedBigInteger('user_id'); // Menghubungkan ke ID akun user Laravel
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('nama_orang_tua');
            $table->text('alamat');
            $table->string('file_kk'); // Menyimpan nama file KK
            $table->string('file_akta'); // Menyimpan nama file Akta
            $table->string('file_ijazah');
            $table->string('status')->default('Pending'); // Status awal otomatis Pending
            $table->text('catatan_admin')->nullable(); // Catatan dari admin jika ditolak/acc
            $table->timestamps(); // Otomatis membuat kolom created_at & updated_at

            // Opsional: Jika kamu sudah membuat tabel users bawaan Laravel, aktifkan foreign key ini:
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Batalkan Pembuatan Tabel (Rollback)
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftar');
    }
};