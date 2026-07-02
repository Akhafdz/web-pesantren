<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    /**
     * 1. ENDPOINT: SIMPAN FORMULIR & BERKAS
     */
    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nama_orang_tua' => 'required|string|max:255',
            'no_whatsapp' => 'required|string|max:20', // <--- Menerima kiriman 'no_whatsapp' dari JavaScript di blade
            'alamat' => 'required|string',
            'file_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_akta' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        // Cek apakah data pendaftaran user ini sudah ada sebelumnya di MySQL
        $pendaftarLama = DB::table('pendaftar')->where('user_id', $request->user_id)->first();

        // Jika data baru (belum pernah daftar), file berkas WAJIB diunggah
        if (!$pendaftarLama) {
            if (!$request->hasFile('file_kk') || !$request->hasFile('file_akta') || !$request->hasFile('file_ijazah')) {
                return response()->json(['error' => 'Semua berkas pendaftaran wajib diunggah!'], 400);
            }
        }

        DB::beginTransaction();
        try {
            // Ambil nama file lama sebagai cadangan jika tidak di-upload ulang
            $namaFileKK = $pendaftarLama ? $pendaftarLama->file_kk : '';
            $namaFileAkta = $pendaftarLama ? $pendaftarLama->file_akta : '';
            $namaFileIjazah = $pendaftarLama ? $pendaftarLama->file_ijazah : '';

            // Jika upload KK baru
            if ($request->hasFile('file_kk')) {
                $fileKK = $request->file('file_kk');
                $namaFileKK = 'KK_' . $request->user_id . '_' . time() . '_' . str_replace(' ', '_', $fileKK->getClientOriginalName());
                $fileKK->storeAs('berkas-santri', $namaFileKK);
            }

            // Jika upload Akta baru
            if ($request->hasFile('file_akta')) {
                $fileAkta = $request->file('file_akta');
                $namaFileAkta = 'AKTA_' . $request->user_id . '_' . time() . '_' . str_replace(' ', '_', $fileAkta->getClientOriginalName());
                $fileAkta->storeAs('berkas-santri', $namaFileAkta);
            }

            // Jika upload Ijazah baru
            if ($request->hasFile('file_ijazah')) {
                $fileIjazah = $request->file('file_ijazah');
                $namaFileIjazah = 'IJAZAH_' . $request->user_id . '_' . time() . '_' . str_replace(' ', '_', $fileIjazah->getClientOriginalName());
                $fileIjazah->storeAs('berkas-santri', $namaFileIjazah);
            }

            $dataPayload = [
                'nama_lengkap' => $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'nama_orang_tua' => $request->nama_orang_tua,
                'no_wa' => $request->no_whatsapp, // <--- Memetakan input 'no_whatsapp' dari frontend ke kolom 'no_wa' database
                'alamat' => $request->alamat,
                'file_kk' => $namaFileKK,
                'file_akta' => $namaFileAkta,
                'file_ijazah' => $namaFileIjazah,
                'status' => 'Pending', // Otomatis balik jadi Pending biar diperiksa admin lagi
                'catatan_admin' => null, // Bersihkan catatan penolakan lama
                'updated_at' => now()
            ];

            if ($pendaftarLama) {
                // JIKA AKUN SUDAH ADA (REVISI/UPDATE RECORD PREVIOUS)
                DB::table('pendaftar')->where('user_id', $request->user_id)->update($dataPayload);
                
                DB::table('berkas')->where('user_id', $request->user_id)->update([
                    'file_kk' => $namaFileKK,
                    'file_akta' => $namaFileAkta,
                    'file_ijazah' => $namaFileIjazah,
                    'updated_at' => now()
                ]);
                $msg = 'Formulir pendaftaran berhasil diperbarui dan dikirim ulang! 🎉';
            } else {
                // JIKA BENAR-BENAR BARU PERTAMA DAFTAR
                $dataPayload['user_id'] = $request->user_id;
                $dataPayload['created_at'] = now();
                DB::table('pendaftar')->insert($dataPayload);

                DB::table('berkas')->insert([
                    'user_id' => $request->user_id,
                    'file_kk' => $namaFileKK,
                    'file_akta' => $namaFileAkta,
                    'file_ijazah' => $namaFileIjazah,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $msg = 'Formulir pendaftaran sukses dikirim ke server! 🎉';
            }

            DB::commit();
            return response()->json(['message' => $msg], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal memproses data: ' . $e->getMessage()], 500);
        }
    }

    /**
     * 2. ENDPOINT: CEK STATUS PENDAFTARAN (FIXED FOR FRONTEND)
     */
    public function cekStatus(Request $request)
    {
        $userId = $request->query('user_id');

        if (!$userId) {
            return response()->json(['error' => 'User ID wajib dilampirkan'], 400);
        }

        // Cari data pendaftar berdasarkan user_id
        $pendaftar = DB::table('pendaftar')->where('user_id', $userId)->first();

        // Format dikembalikan agar sesuai dengan pembacaan JavaScript di santri.blade.php
        if ($pendaftar) {
            return response()->json([
                'exists' => true,
                'pendaftar' => $pendaftar
            ], 200);
        } else {
            return response()->json([
                'exists' => false,
                'pendaftar' => null
            ], 200);
        }
    }

    /**
     * 3. ADMIN: AMBIL SEMUA DATA PENDAFTAR
     */
    public function semuaPendaftar()
    {
        // Mengambil semua data pendaftar dari MySQL diurutkan dari yang paling terbaru
        $listPendaftar = DB::table('pendaftar')->orderBy('created_at', 'desc')->get();
        return response()->json(['data' => $listPendaftar], 200);
    }

    /**
     * 4. ADMIN: UPDATE STATUS LULUS / TOLAK + CATATAN REVISI
     */
    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'status' => 'required|in:Pending,Diterima,Ditolak',
            'catatan_admin' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        // Update status di tabel pendaftar berdasarkan user_id santri
        DB::table('pendaftar')
            ->where('user_id', $request->user_id)
            ->update([
                'status' => $request->status,
                'catatan_admin' => $request->catatan_admin,
                'updated_at' => now()
            ]);

        return response()->json(['message' => 'Status pendaftaran berhasil diperbarui!'], 200);
    }

    public function lihatBerkas($namafile)
    {
        // Cari lokasi file asli di folder storage/app/berkas-santri/
        $path = storage_path('app/private/berkas-santri/' . $namafile);

        // Jika file fisik tidak ada di folder asli, beri tahu lewat eror 404
        if (!file_exists($path)) {
            return response()->json(['error' => 'File fisik tidak ditemukan di folder storage/app/berkas-santri/'], 404);
        }

        // Ambil tipe file asli (image/png, image/jpeg, atau application/pdf)
        $mimeType = mime_content_type($path);

        // Kirim file murni ke browser tanpa melewati restriksi public/storage
        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $namafile . '"'
        ]);
    }

    /**
     * 5. ARTIKEL: SIMPAN ARTIKEL BARU (ADMIN)
     */
    public function simpanArtikel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'konten' => 'required|string',
            'gambar_artikel' => 'required|file|mimes:jpg,jpeg,png|max:2048', // Maksimal 2MB
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        try {
            $namaGambar = '';
            if ($request->hasFile('gambar_artikel')) {
                $file = $request->file('gambar_artikel');
                // Simpan dengan nama unik di folder private/artikel
                $namaGambar = 'ARTIKEL_' . time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $file->storeAs('artikel', $namaGambar); // Otomatis masuk ke storage/app/private/artikel
            }

            DB::table('artikel')->insert([
                'judul' => $request->judul,
                'kategori' => $request->kategori,
                'konten' => $request->konten,
                'gambar_artikel' => $namaGambar,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['message' => 'Artikel berhasil diterbitkan! 🎉'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal menyimpan artikel: ' . $e->getMessage()], 500);
        }
    }

    /**
     * 6. ARTIKEL: AMBIL SEMUA ARTIKEL UNTUK BERANDA (PUBLIK)
     */
    public function ambilArtikel()
    {
        // Mengambil artikel terbaru
        $artikel = DB::table('artikel')->orderBy('created_at', 'desc')->get();
        return response()->json(['data' => $artikel], 200);
    }

    /**
     * 7. ARTIKEL: BYPASS LIHAT GAMBAR ARTIKEL (ANTI-403)
     */
    public function lihatGambarArtikel($namafile)
    {
        $path = storage_path('app/private/artikel/' . $namafile);

        if (!file_exists($path)) {
            return response()->json(['error' => 'Gambar artikel tidak ditemukan.'], 404);
        }

        $mimeType = mime_content_type($path);

        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $namafile . '"'
        ]);
    }
}