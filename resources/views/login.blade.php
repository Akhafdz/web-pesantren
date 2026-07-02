<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Masuk | PAJ At-Tamur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .auth-container { max-width: 450px; margin-top: 80px; }
        .toggle-link { cursor: pointer; color: #198754; text-decoration: underline; }
    </style>
</head>
<body class="bg-light">
<div class="position-absolute top-0 start-0 m-4">
    <a href="/" class="btn btn-outline-success btn-sm fw-bold shadow-sm rounded-pill px-3">
        <i class="fas fa-home me-1"></i> Beranda
    </a>
</div>
    <div class="container auth-container">
        <!-- CARD LOGIN -->
        <div class="card border-0 shadow-sm p-4 rounded-3" id="box-login">
            <h3 class="fw-bold text-success text-center mb-1">Masuk Santri</h3>
            <p class="text-muted text-center small mb-4">Silakan masuk untuk mengakses formulir pendaftaran</p>
            
            <form id="form-login">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Alamat Email</label>
                    <input type="email" id="login-email" class="form-control" required placeholder="nama@email.com">
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" id="login-password" class="form-control" required placeholder="******">
                </div>
                <button type="submit" class="btn btn-success w-100 fw-bold py-2 mb-3">Masuk Sekarang</button>
                <p class="text-center small mb-0">Belum punya akun? <span class="toggle-link fw-bold" onclick="toggleForm()">Daftar di sini</span></p>
            </form>
        </div>

        <!-- CARD REGISTER (Default Tersembunyi) -->
        <div class="card border-0 shadow-sm p-4 rounded-3 d-none" id="box-register">
            <h3 class="fw-bold text-success text-center mb-1">Buat Akun Baru</h3>
            <p class="text-muted text-center small mb-4">Daftarkan akun santri Anda untuk sistem PAJAT</p>
            
            <form id="form-register">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" id="reg-name" class="form-control" required placeholder="Ahmad">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Alamat Email</label>
                    <input type="email" id="reg-email" class="form-control" required placeholder="ahmad@email.com">
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Password (Minimal 6 Karakter)</label>
                    <input type="password" id="reg-password" class="form-control" minlength="6" required placeholder="******">
                </div>
                <button type="submit" class="btn btn-success w-100 fw-bold py-2 mb-3">Daftar Akun</button>
                <p class="text-center small mb-0">Sudah punya akun? <span class="toggle-link fw-bold" onclick="toggleForm()">Masuk di sini</span></p>
            </form>
        </div>
    </div>

    <script>
        // Fungsi pindah form Login <-> Register
        function toggleForm() {
            document.getElementById('box-login').classList.toggle('d-none');
            document.getElementById('box-register').classList.toggle('d-none');
        }

        // =========================================================================
        // SCRIPT KEAMANAN: ANTI-FORWARD (Mencegah user masuk lagi jika sudah logout/iseng klik next)
        // =========================================================================
        window.history.pushState(null, null, window.location.href);
        window.addEventListener('popstate', function () {
            window.history.pushState(null, null, window.location.href);
        });

        // =========================================================================
        // AJAX HANDLER: REGISTRASI USER KE MYSQL LARAVEL
        // =========================================================================
        document.getElementById('form-register').addEventListener('submit', async (e) => {
            e.preventDefault();
            try {
                const res = await fetch('/api/register', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        name: document.getElementById('reg-name').value,
                        email: document.getElementById('reg-email').value,
                        password: document.getElementById('reg-password').value
                    })
                });
                const data = await res.json();
                if (!res.ok) throw new Error(data.error || 'Gagal Registrasi');
                
                alert(data.message);
                toggleForm(); // Kembalikan ke form login
            } catch (err) {
                alert('Gagal Daftar: ' + err.message);
            }
        });

        // =========================================================================
        // AJAX HANDLER: LOGIN USER + SETTING SESSION STORAGE
        // =========================================================================
        document.getElementById('form-login').addEventListener('submit', async (e) => {
            e.preventDefault();
            try {
                const res = await fetch('/api/login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        email: document.getElementById('login-email').value,
                        password: document.getElementById('login-password').value
                    })
                });
                const data = await res.json();
                if (!res.ok) throw new Error(data.error || 'Gagal Login');

                // Sesuai Request Proteksi: Taruh di sessionStorage agar otomatis musnah saat tab/browser ditutup!
                sessionStorage.setItem('user_session', JSON.stringify({
                    user: data.user,
                    login_time: new Date().getTime()
                }));

                alert('Login Berhasil! Mengalihkan ke dashboard...');
                
                // Cek Role Akses
                if (data.user.role === 'admin') {
                    window.location.href = '/admin'; // Menuju dashboard admin (jika nanti dibuat)
                } else {
                    window.location.href = '/santri'; // Menuju formulir pendaftaran santri
                }

            } catch (err) {
                alert('Gagal Masuk: ' + err.message);
            }
        });
    </script>
</body>
</html>