<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Santri - Pesantren At-Tamur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"><i class="fas fa-mosque me-2"></i>Pesantren Anak Jalanan At-Tamur</a>
            <div class="ms-auto">
                <span class="text-white me-3" id="user-display-name">Memuat nama...</span>
                <button class="btn btn-danger btn-sm fw-bold" id="btn-logout">Keluar</button>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row">
            
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm p-4 rounded-3 bg-white">
                    <h4 class="fw-bold text-dark mb-0">Status Pendaftaran Anda: 
                        <span class="badge bg-secondary fs-6 ms-2" id="status-pendaftaran">Belum Mengisi Formulir</span>
                    </h4>
                    
                    <div id="box-pesan-status" class="mt-3 d-none"></div>

                    <div class="alert alert-danger shadow-sm border-0 p-3 mt-3 rounded-3 d-none" id="box-catatan-admin">
                        <h5 class="fw-bold text-danger mb-1"><i class="fas fa-exclamation-triangle me-2"></i> Alasan Penolakan Berkas:</h5>
                        <div class="bg-white text-danger p-3 rounded border-start border-danger border-4 fw-bold shadow-sm my-2">
    <span id="text-catatan-admin"></span>
</div>
                        <small class="text-muted">* Silakan perbaiki data di bawah, unggah dokumen revisi, lalu klik Kirim Ulang.</small>
                    </div>
                </div>
            </div>

            <div class="col-md-12 d-none" id="box-formulir">
                <div class="card border-0 shadow-sm p-4 rounded-3 bg-white">
                    <h3 class="fw-bold text-success mb-4 border-bottom pb-2" id="title-form">Formulir Pendaftaran & Upload Berkas</h3>
                    
                    <form id="form-pendaftaran">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama Lengkap (Sesuai Ijazah)</label>
                                <input type="text" id="nama" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tempat Lahir</label>
                                <input type="text" id="tempat-lahir" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanggal Lahir</label>
                                <input type="date" id="tanggal-lahir" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama Orang Tua / Wali</label>
                                <input type="text" id="ortu" class="form-control" required>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold">No. WhatsApp Aktif</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="fab fa-whatsapp text-success fw-bold"></i></span>
                                    <input type="tel" id="whatsapp" class="form-control" placeholder="Contoh: 08xxxxxxxxxx" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold">Alamat Lengkap</label>
                                <textarea id="alamat" class="form-control" rows="2" required></textarea>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold text-danger">Upload Kartu Keluarga Max 2MB (PDF/JPG/PNG)</label>
                                <input type="file" id="file-kk" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold text-danger">Upload Akta Kelahiran Max 2MB (PDF/JPG/PNG)</label>
                                <input type="file" id="file-akta" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold text-danger">Upload Ijazah Terakhir Max 2MB (PDF/JPG/PNG)</label>
                                <input type="file" id="file-ijazah" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                            </div>
                        </div>
                        
                        <button type="submit" id="btn-submit" class="btn btn-success fw-bold px-4 py-2 mt-3 shadow-sm">
                            <i class="fas fa-paper-plane me-1"></i> Kirim
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        let currentUser = null; 

        // =========================================================================
        // SCRIPT KEAMANAN: ANTI-BACK
        // =========================================================================
        window.history.pushState(null, null, window.location.href);
        window.addEventListener('popstate', function () {
            sessionStorage.clear();
            window.location.href = '/login'; 
        });

        // =========================================================================
        // VALIDASI PROTEKSI SESSION DATA
        // =========================================================================
        function inisialisasiDashboard() {
            try {
                const sessionData = JSON.parse(sessionStorage.getItem('user_session'));
                
                if (!sessionData || !sessionData.user) {
                    throw new Error("Sesi tidak valid.");
                }

                currentUser = sessionData.user;
                const namaUser = currentUser.display_name || currentUser.email;
                document.getElementById('user-display-name').innerText = `Halo, ${namaUser}`;

                // Jalankan fungsi cek status pendaftaran
                cekStatusPendaftaran();

            } catch (err) {
                console.warn("Akses ditolak, mengalihkan...", err.message);
                sessionStorage.clear();
                window.location.href = '/login'; 
            }
        }

        // =========================================================================
        // AMBIL STATUS PENDAFTARAN DARI MYSQL (ANTI-STUCK FIX)
        // =========================================================================
        async function cekStatusPendaftaran() {
            try {
                const res = await fetch('/api/pendaftaran/status?user_id=' + currentUser.id);
                const data = await res.json();
                
                const badgeStatus = document.getElementById('status-pendaftaran');
                const boxPesanStatus = document.getElementById('box-pesan-status');
                const boxCatatanAdmin = document.getElementById('box-catatan-admin');
                const textCatatanAdmin = document.getElementById('text-catatan-admin');
                const boxFormulir = document.getElementById('box-formulir');
                const btnSubmit = document.getElementById('btn-submit');
                const titleForm = document.getElementById('title-form');

                // Setel ulang kondisi tampilan ke default semenit awal
                boxPesanStatus.classList.add('d-none');
                boxCatatanAdmin.classList.add('d-none');
                boxFormulir.classList.add('d-none');

                // JIKA USER SUDAH PERNAH ISI FORMULIR
                if (data.exists && data.pendaftar) {
                    const p = data.pendaftar;
                    
                    // Update Teks Badge Status Utama
                    badgeStatus.innerText = p.status;

                    // -------------------------------------------------------------
                    // KONDISI 1: STATUS PENDING ATAU DITERIMA (FORM DIKUNCI TOTAL)
                    // -------------------------------------------------------------
                    if (p.status === 'Pending' || p.status === 'Diterima') {
                        boxFormulir.classList.add('d-none'); // Sembunyikan form agar tidak ganda
                        boxPesanStatus.classList.remove('d-none'); // Tampilkan box informasi kunci
                        
                        if (p.status === 'Diterima') {
                            badgeStatus.className = "badge bg-success fs-6 ms-2";
                            boxPesanStatus.innerHTML = `
                                <div class="alert alert-success border-0 p-3 mb-0 rounded-3">
                                    <h5 class="fw-bold"><i class="fas fa-check-circle me-1"></i> Selamat, Anda Lulus!</h5>
                                    <p class="mb-0 small">Anda resmi dinyatakan diterima di PAJ At-Tamur. Silakan tunggu informasi pendaftaran ulang selanjutnya.</p>
                                </div>
                            `;
                        } else {
                            badgeStatus.className = "badge bg-warning text-dark fs-6 ms-2";
                            boxPesanStatus.innerHTML = `
                                <div class="alert alert-warning border-0 text-dark p-3 mb-0 rounded-3">
                                    <h5 class="fw-bold"><i class="fas fa-clock me-1"></i> Berkas Sedang Ditinjau</h5>
                                    <p class="mb-0 small">Formulir Anda sudah di kirim. Tim administrasi kami sedang melakukan verifikasi formulir Anda.</p>
                                    <p class="mb-0 small">Bila ada pertanyaan, Hubungi nomor admin 08xxxxxxxx.</p>
                                </div>
                            `;
                        }
                    } 
                    // -------------------------------------------------------------
                    // KONDISI 2: STATUS DITOLAK (BUKA FORM + INJEKSI REVISI)
                    // -------------------------------------------------------------
                    else if (p.status === 'Ditolak') {
                        badgeStatus.className = "badge bg-danger fs-6 ms-2";
                        
                        // Tampilkan kotak merah Catatan Admin & buka formnya
                        boxCatatanAdmin.classList.remove('d-none');
                        textCatatanAdmin.innerText = p.catatan_admin || 'Tidak ada catatan spesifik dari admin.';
                        boxFormulir.classList.remove('d-none'); 

                        // Ubah tema Judul & Tombol Form ke mode "Revisi" (Merah)
                        titleForm.innerHTML = '⚠️ Perbaikan Berkas & Formulir Pendaftaran';
                        titleForm.className = "fw-bold text-danger mb-4 border-bottom pb-2";
                        
                        btnSubmit.innerHTML = '<i class="fas fa-sync me-1"></i> Simpan & Kirim Ulang Berkas Perbaikan';
                        btnSubmit.className = "btn btn-danger fw-bold px-4 py-2 mt-3 shadow-sm";

                        // Isi otomatis nilai input berdasarkan data lama di database
                        document.getElementById('nama').value = p.nama_lengkap || '';
                        document.getElementById('tempat-lahir').value = p.tempat_lahir || '';
                        document.getElementById('tanggal-lahir').value = p.tanggal_lahir || '';
                        document.getElementById('ortu').value = p.nama_orang_tua || '';
                        document.getElementById('whatsapp').value = p.no_whatsapp || ''; // Autocompletion No WA lama
                        document.getElementById('alamat').value = p.alamat || '';

                        // Matikan fungsi required pada file (Agar tidak perlu upload ulang jika file itu sudah benar)
                        document.getElementById('file-kk').required = false;
                        document.getElementById('file-akta').required = false;
                        document.getElementById('file-ijazah').required = false;
                    }
                } 
                // -----------------------------------------------------------------
                // KONDISI 3: BELUM PERNAH DAFTAR SAMA SEKALI (FORM BARU)
                // -----------------------------------------------------------------
                else {
                    badgeStatus.innerText = "Belum Mengisi Formulir";
                    badgeStatus.className = "badge bg-secondary fs-6 ms-2";
                    boxFormulir.classList.remove('d-none'); // Tampilkan form kosong murni
                }
            } catch (err) {
                console.error("Gagal memproses data status:", err);
            }
        }

        // =========================================================================
        // EVENT HANDLER SUBMIT FORMULIR
        // =========================================================================
        document.getElementById('form-pendaftaran').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            if (!currentUser) {
                alert("Sesi habis, silakan login kembali.");
                window.location.href = '/login';
                return;
            }

            const btnSubmit = document.getElementById('btn-submit');
            const teksAwalTombol = btnSubmit.innerHTML;
            btnSubmit.innerText = "Sedang Memproses & Mengunggah... Mohon Tunggu...";
            btnSubmit.disabled = true;

            try {
                const formData = new FormData();
                formData.append('user_id', currentUser.id);
                formData.append('nama_lengkap', document.getElementById('nama').value);
                formData.append('tempat_lahir', document.getElementById('tempat-lahir').value);
                formData.append('tanggal_lahir', document.getElementById('tanggal-lahir').value);
                formData.append('nama_orang_tua', document.getElementById('ortu').value);
                formData.append('no_whatsapp', document.getElementById('whatsapp').value); // Append Data No WA Baru ke API
                formData.append('alamat', document.getElementById('alamat').value);
                
                // Ambil file biner (Hanya ditambahkan jika user memilih file baru)
                if(document.getElementById('file-kk').files[0]) formData.append('file_kk', document.getElementById('file-kk').files[0]);
                if(document.getElementById('file-akta').files[0]) formData.append('file_akta', document.getElementById('file-akta').files[0]);
                if(document.getElementById('file-ijazah').files[0]) formData.append('file_ijazah', document.getElementById('file-ijazah').files[0]);

                const res = await fetch('/api/pendaftaran/simpan', {
                    method: 'POST',
                    body: formData
                });
                
                const hasilBackend = await res.json();

                if (!res.ok) throw new Error(hasilBackend.error || 'Gagal terhubung ke Laravel.');

                alert(hasilBackend.message || 'Data pendaftaran berhasil diproses!');
                
                // REFRESH TOTAL HALAMAN: Menghilangkan form otomatis dan mengunci menjadi badge Pending kembali
                window.location.reload();

            } catch (err) {
                alert("❌ Gagal Mengirim Formulir: " + err.message);
                btnSubmit.innerHTML = teksAwalTombol;
                btnSubmit.disabled = false;
            }
        });

        // TOMBOL LOGOUT
        document.getElementById('btn-logout').addEventListener('click', () => {
            sessionStorage.clear();
            window.location.href = '/login';
        });

        document.addEventListener("DOMContentLoaded", inisialisasiDashboard);
    </script>
</body>
</html>