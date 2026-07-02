<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Pesantren Anak Jalanan At-Tamur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="#"><i class="fas fa-user-shield me-2"></i> PANEL ADMIN AT-TAMUR</a>
            <div class="ms-auto">
                <span class="text-white me-3" id="admin-name">Admin Pesantren</span>
                <button class="btn btn-danger btn-sm fw-bold" id="btn-logout">Keluar</button>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-12">
                <h3 class="fw-bold text-dark mb-4"><i class="fas fa-folder-open text-success me-2"></i> Verifikasi Berkas & Formulir Santri</h3>
                
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-success">
                                <tr>
                                    <th>Nama Santri</th>
                                    <th>TTL & Alamat</th>
                                    <th>Orang Tua</th>
                                    <th>WhatsApp</th> <th class="text-center">Berkas</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi Operasi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pendaftar">
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Sedang memuat data dari database MySQL...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalProses" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold" id="modal-title-nama">Proses Pendaftaran</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="modal-user-id">
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tentukan Keputusan</label>
                        <select id="modal-status" class="form-select" required>
                            <option value="Diterima">Diterima (Lolos Seleksi)</option>
                            <option value="Ditolak">Ditolak / Butuh Revisi Berkas</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Catatan Admin / Alasan Penolakan</label>
                        <textarea id="modal-catatan" class="form-control" rows="3" placeholder="Contoh: Tolong upload ulang file Ijazah karena terpotong atau buram..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="btn-simpan-keputusan" class="btn btn-success fw-bold">Simpan Keputusan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow border-0 mt-5 mb-5 rounded-3">
        <div class="card-header bg-success text-white py-3">
            <h5 class="mb-0 fw-bold"><i class="fas fa-feather-alt me-2"></i> Tulis & Upload Artikel Baru</h5>
        </div>
        <div class="card-body p-4">
            <form id="formArtikel" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Judul Artikel / Berita</label>
                        <input type="text" name="judul" class="form-control" placeholder="Masukkan judul yang menarik..." required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="" disabled selected>Pilih Kategori...</option>
                            <option value="Kegiatan">Kegiatan</option>
                            <option value="Opini">Opini</option>
                            <option value="Pengumuman">Pengumuman</option>
                            <option value="Kisah Santri">Kisah Santri</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Isi Konten Artikel</label>
                        <textarea name="konten" class="form-control" rows="5" placeholder="Tuliskan isi berita lengkap di sini..." required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Upload Gambar Cover</label>
                        <input type="file" name="gambar_artikel" class="form-control" accept="image/*" required>
                        <div class="form-text">Format: JPG, JPEG, PNG (Maks 2MB)</div>
                    </div>
                    <div class="col-md-6 d-flex align-items-end justify-content-end">
                        <button type="submit" class="btn btn-success fw-bold px-4 py-2 shadow-sm">
                            <i class="fas fa-paper-plane me-1"></i> Terbitkan Artikel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let targetModal = null;

        // =========================================================================
        // SCRIPT VALIDASI AKSES: HANYA BOLEH MASUK JIKA ROLE = ADMIN
        // =========================================================================
        function proteksiHalamanAdmin() {
            const sessionData = JSON.parse(sessionStorage.getItem('user_session'));
            
            // Jika session kosong atau role-nya bukan admin, usir paksa ke login
            if (!sessionData || !sessionData.user || sessionData.user.role !== 'admin') {
                alert("Akses Terlarang! Halaman ini khusus untuk Akun Admin Pesantren.");
                sessionStorage.clear();
                window.location.href = '/login';
                return;
            }

            document.getElementById('admin-name').innerText = `Admin: ${sessionData.user.display_name}`;
            targetModal = new bootstrap.Modal(document.getElementById('modalProses'));
            muatDataPendaftar();
        }

        // =========================================================================
        // AJAX: AMBIL DATA PENDAFTAR DARI MYSQL VIA CONTROLLER
        // =========================================================================
        async function muatDataPendaftar() {
            try {
                const res = await fetch('/api/admin/pendaftar');
                const hasil = await res.json();
                const tbody = document.getElementById('tabel-pendaftar');
                tbody.innerHTML = "";

                if (hasil.data.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="7" class="text-center py-4 text-muted">Belum ada santri yang mengirimkan formulir pendaftaran.</td></tr>`;
                    return;
                }

                hasil.data.forEach(p => {
                    // Penyetelan warna badge status
                    let badgeColor = "bg-warning text-dark";
                    if(p.status === 'Diterima') badgeColor = "bg-success";
                    if(p.status === 'Ditolak') badgeColor = "bg-danger";

                    // Format nomor WA santri untuk api link wa.me
                    let waLink = p.no_wa ? `https://wa.me/${formatWhatsApp(p.no_wa)}` : '#';
                    let waDisplay = p.no_wa ? `<a href="${waLink}" target="_blank" class="btn btn-sm btn-outline-success fw-bold text-nowrap shadow-sm"><i class="fab fa-whatsapp me-1"></i> ${p.no_wa}</a>` : `<span class="text-muted small">Tidak ada</span>`;

                    // Render baris tabel + Link mengarah ke folder public/storage Laravel
                    tbody.innerHTML += `
                        <tr>
                            <td>
                                <strong class="text-dark">${p.nama_lengkap}</strong><br>
                                <small class="text-muted">User ID: ${p.user_id}</small>
                            </td>
                            <td>
                                <small>${p.tempat_lahir}, ${p.tanggal_lahir}</small><br>
                                <small class="text-muted d-block" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${p.alamat}</small>
                            </td>
                            <td><small>${p.nama_orang_tua}</small></td>
                            <td>${waDisplay}</td> <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="/api/lihat-berkas/${p.file_kk}" target="_blank" class="btn btn-outline-secondary"><i class="fas fa-file-image me-1"></i>KK</a>
                                    <a href="/api/lihat-berkas/${p.file_akta}" target="_blank" class="btn btn-outline-secondary"><i class="fas fa-file-image me-1"></i>Akta</a>
                                    <a href="/api/lihat-berkas/${p.file_ijazah}" target="_blank" class="btn btn-outline-secondary"><i class="fas fa-file-image me-1"></i>Ijazah</a>
                                </div>
                            </td>
                            <td class="text-center"><span class="badge ${badgeColor}">${p.status}</span></td>
                            <td class="text-center">
                                <button class="btn btn-success btn-sm fw-bold px-3 shadow-sm" onclick="bukaModalProses(${p.user_id}, '${p.nama_lengkap}', '${p.status}', '${p.catatan_admin || ''}')">
                                    <i class="fas fa-edit me-1"></i> Proses
                                </button>
                            </td>
                        </tr>
                    `;
                });
            } catch (err) {
                console.error("Gagal mengambil data pendaftar:", err);
            }
        }

        // Helper fungsi mengubah format nomor HP (08xx ke 628xx) untuk WhatsApp Link API
        function formatWhatsApp(number) {
            if (!number) return "";
            let cleaned = number.replace(/\D/g, ""); // Bersihkan semua simbol/karakter selain angka
            if (cleaned.startsWith("0")) {
                cleaned = "62" + cleaned.slice(1);
            }
            return cleaned;
        }

        // Buka modal & isi data default pendaftar yang dipilih
        function bukaModalProses(userId, nama, status, catatan) {
            document.getElementById('modal-user-id').value = userId;
            document.getElementById('modal-title-nama').innerText = `Proses: ${nama}`;
            document.getElementById('modal-status').value = status === 'Pending' ? 'Diterima' : status;
            document.getElementById('modal-catatan').value = catatan;
            targetModal.show();
        }

        // =========================================================================
        // AJAX: SIMPAN PERUBAHAN STATUS KE BACKEND MYSQL LARAVEL
        // =========================================================================
        document.getElementById('btn-simpan-keputusan').addEventListener('click', async () => {
            const userId = document.getElementById('modal-user-id').value;
            const status = document.getElementById('modal-status').value;
            const catatan = document.getElementById('modal-catatan').value;

            try {
                const res = await fetch('/api/admin/pendaftar/update', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        user_id: userId,
                        status: status,
                        catatan_admin: catatan
                    })
                });

                const data = await res.json();
                if (!res.ok) throw new Error(data.error);

                alert('🎉 Berhasil memperbarui status pendaftaran santri!');
                targetModal.hide();
                muatDataPendaftar(); // Refresh tabel data

            } catch (err) {
                alert('Gagal memproses keputusan: ' + err.message);
            }
        });

        // Tombol Logout
        document.getElementById('btn-logout').addEventListener('click', () => {
            sessionStorage.clear();
            window.location.href = '/login';
        });

        document.addEventListener("DOMContentLoaded", proteksiHalamanAdmin);

        document.getElementById('formArtikel').addEventListener('submit', function(e) {
            e.preventDefault();
            
            let formData = new FormData(this);

            fetch('/api/simpan-artikel', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert('Gagal: ' + data.error);
                } else {
                    alert(data.message);
                    document.getElementById('formArtikel').reset(); // Reset form jika sukses
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan sistem saat mengunggah artikel.');
            });
        });
    </script>
</body>
</html>