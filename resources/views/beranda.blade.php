<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesantren Anak Jalanan At-Tamur | Media Informasi Resmi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 100, 0, 0.75), rgba(0, 50, 0, 0.9)), url('storage/hero.png') no-repeat center center/cover;
            color: white;
            padding: 120px 0;
        }
        .features-icon {
            font-size: 3rem;
            color: #198754;
        }
        /* Custom Carousel Controls */
        .carousel-control-prev, .carousel-control-next {
            width: 5%;
        }
        .carousel-control-prev-icon, .carousel-control-next-icon {
            background-color: rgba(25, 135, 84, 0.8);
            padding: 20px;
            border-radius: 50%;
        }
        /* Solusi CSS Anti-Stretch untuk Deskripsi Artikel Ringkas */
        .clamp-text {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top shadow">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="#" onclick="kembaliKeBeranda()">
    <img src="{{ asset('storage/app/public/logo.png') }}" alt="Logo Ponpes At-Tamur" height="35" class="me-2">
    Ponpes At-Tamur
</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto fw-semibold">
                    <li class="nav-item"><a class="nav-link active" href="#beranda" onclick="kembaliKeBeranda()">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tentang-kami" onclick="kembaliKeBeranda()">Tentang Kami</a></li>
                    <li class="nav-item"><a class="nav-link" href="#program" onclick="kembaliKeBeranda()">Program Belajar</a></li>
                    <li class="nav-item"><a class="nav-link" href="#galeri" onclick="kembaliKeBeranda()">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="#berita" onclick="kembaliKeBeranda(true)">Berita & Artikel</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                </ul>
                <a href="/login" class="btn btn-warning btn-sm ms-lg-3 fw-bold text-dark px-3 rounded-pill shadow-sm">
                    <i class="fas fa-sign-in-alt me-1"></i> Pendaftaran Online
                </a>
            </div>
        </div>
    </nav>

    <div id="section-landing-page">
        <header id="beranda" class="hero-section text-center">
            <div class="container">
                <h1 class="display-4 fw-bold mb-3">Pesantren Anak Jalanan At-Tamur</h1>
                <p class="lead mb-4 fs-4">Memberikan Ruang Belajar, Pendampingan, dan Pendidikan Karakter Terbuka Berbasis Komunitas</p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="/login" class="btn btn-warning btn-lg px-4 gap-3 fw-bold shadow">Daftar Jadi Santri Sekarang</a>
                    <a href="#tentang-kami" class="btn btn-outline-light btn-lg px-4">Pelajari Profil Kami</a>
                </div>
            </div>
        </header>

        <section id="tentang-kami" class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <span class="text-success fw-bold text-uppercase tracking-wider">Profil Lembaga</span>
                    <h2 class="fw-bold text-dark mt-2">Mengenal Lebih Dekat Pondok Pesantren Anak Jalanan At-Tamur</h2>
                    <p class="text-muted mt-3">Pesantren Anak Jalanan At-Tamur (PAJAT) merupakan lembaga pendidikan berbasis komunitas yang mendedikasikan diri untuk merangkul anak-anak jalanan. Kami berupaya memberikan bekal moral, bimbingan keagamaan, serta keterampilan hidup demi masa depan yang lebih bermartabat.</p>
                    <div class="row mt-4">
                        <div class="col-6">
                            <h5 class="fw-bold"><i class="fas fa-check-circle text-success me-2"></i> Pendidikan Dasar</h5>
                        </div>
                        <div class="col-6">
                            <h5 class="fw-bold"><i class="fas fa-check-circle text-success me-2"></i> Keterampilan Hidup</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=600" class="img-fluid rounded-3 shadow" alt="Aktivitas Pesantren">
                </div>
            </div>
        </section>

        <hr class="container my-4">

        <section id="program" class="container py-5 bg-white text-center">
            <span class="text-success fw-bold text-uppercase">Layanan Pendidikan</span>
            <h2 class="fw-bold mb-5 mt-2">Program Unggulan Kami</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 p-4 border-0 shadow-sm rounded-3">
                        <div class="features-icon mb-3"><i class="fas fa-book-reader"></i></div>
                        <h4 class="fw-bold">Bimbingan Keagamaan</h4>
                        <p class="text-muted">Pembelajaran Al-Qur'an, tauhid, fiqih dasar, serta pembentukan akhlak mulia sehari-hari.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 p-4 border-0 shadow-sm rounded-3">
                        <div class="features-icon mb-3"><i class="fas fa-tools"></i></div>
                        <h4 class="fw-bold">Pelatihan Kreatif</h4>
                        <p class="text-muted">Pembekalan hard skill/keterampilan praktis agar santri memiliki modal kemandirian ekonomi.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 p-4 border-0 shadow-sm rounded-3">
                        <div class="features-icon mb-3"><i class="fas fa-heart"></i></div>
                        <h4 class="fw-bold">Dukungan Psikososial</h4>
                        <p class="text-muted">Pendampingan emosional dan mental untuk membantu anak-anak beradaptasi meninggalkan jalanan.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="galeri" class="py-5 bg-light">
            <div class="container text-center">
                <span class="text-success fw-bold text-uppercase">Dokumentasi</span>
                <h2 class="fw-bold mb-5 mt-2">Galeri Kegiatan Santri</h2>
                
                <div id="carouselGaleri" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner" id="container-galeri-carousel"></div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselGaleri" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselGaleri" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </section>
    </div>

    <div id="main-homepage-content">
        <section id="berita" class="container py-5">
            <div class="text-center mb-5">
                <button id="btn-kembali-arsip" onclick="kembaliKeBeranda()" class="btn btn-outline-success btn-sm mb-3 fw-bold rounded-pill px-3 shadow-sm d-none">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda Utama
                </button>
                <br>
                <span class="text-success fw-bold text-uppercase" id="sub-judul-berita">Kabar Pesantren</span>
                <h2 class="fw-bold mt-2" id="judul-berita">Berita & Artikel Terbaru</h2>
            </div>
            
            <div class="row g-4" id="container-artikel"></div>

            <div class="row mt-5">
                <div class="col-12 d-flex flex-column align-items-center gap-3">
                    <button class="btn btn-outline-success fw-bold px-4 rounded-pill shadow-sm" id="btn-view-more">
                        Lihat Artikel Lainnya <i class="fas fa-chevron-down ms-1"></i>
                    </button>
                    
                    <nav aria-label="Page navigation" class="mt-2">
                        <ul class="pagination pagination-sm justify-content-center mb-0 shadow-sm" id="pagination-list"></ul>
                    </nav>
                </div>
            </div>
        </section>
    </div>

    <div id="detail-artikel-content" class="container py-5 d-none" style="min-height: 65vh;"></div>

    <footer id="kontak" class="bg-dark text-light pt-5 pb-3">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <h5 class="fw-bold text-success mb-3"><i class="fas fa-mosque me-2"></i> Pondok Pesantren Anak Jalanan At-Tamur</h5>
                    <p class="text-white-50 mb-1">Wadah dedikasi sosial kemanusiaan untuk mencerdaskan generasi marjinal bangsa lewat jalur pendidikan berbasis pesantren komunitas.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5 class="fw-bold mb-3">Kontak</h5>
                    <p class="text-white-50 mb-1"><i class="fas fa-map-marker-alt me-2"></i> Jl. Cibiru Hilir No.04, RT.01/RW.01, Cibiru Hilir, Kec. Cileunyi, Kabupaten Bandung, Jawa Barat 40626</p>
                    <p class="text-white-50 mb-1"><i class="fas fa-phone me-2"></i> +62 xxx xxxx xxxx (WhatsApp)</p>
                    
                    <!-- Wadah Google Maps (Diletakkan di bawah nomor WhatsApp) -->
                    <div class="mt-3 d-inline-block w-100" style="max-width: 400px;">
                        <div class="ratio ratio-21x9 rounded-3 overflow-hidden shadow-sm">
                            <iframe 
                                src="https://www.google.com/maps/embed/v1/place?key=AIzaSyB2NIWI3Tv9iDPrlnowr_0ZqZWoAQydKJU&q=Pondok%20Pesantren%20Anak%20Jalanan%20Attamur%2C%20Jalan%20Cibiru%20Hilir%2C%20RT.01%2C%20Cibiru%20Hilir%2C%20Bandung%20Regency%2C%20West%20Java%2C%20Indonesia&maptype=roadmap" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center text-muted small">
                &copy; 2026 Pesantren At-Tamur.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Variabel global untuk menyimpan data fetch & status halaman
        let listArtikelGlobal = [];
        let currentPage = 1;
        let isArsipView = false; // Penanda jika user sedang membuka seluruh arsip artikel

        document.addEventListener("DOMContentLoaded", function() {
            
            // ==========================================
            // 1. DATA DRIVEN GALERI
            // ==========================================
            const fotoGaleri = [
                "{{ asset('storage/hero.png') }}",
                "https://images.unsplash.com/photo-1497633762265-9d179a990aa6?q=80&w=400",
                "https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=400",
                "https://images.unsplash.com/photo-1516627145497-ae6968895b74?q=80&w=400",
                "https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=400",
                "https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=400"
            ];

            function renderGaleriCarousel() {
                const container = document.getElementById('container-galeri-carousel');
                container.innerHTML = '';
                
                for (let i = 0; i < fotoGaleri.length; i += 3) {
                    const isActive = i === 0 ? 'active' : '';
                    let slideItems = '';
                    
                    for (let j = i; j < i + 3 && j < fotoGaleri.length; j++) {
                        slideItems += `
                            <div class="col-md-4 col-12 mb-3">
                                <img src="${fotoGaleri[j]}" class="img-fluid rounded shadow-sm w-100" style="height: 250px; object-fit: cover;" alt="Galeri At-Tamur">
                            </div>
                        `;
                    }

                    container.innerHTML += `
                        <div class="carousel-item ${isActive}">
                            <div class="row g-3 px-5">
                                ${slideItems}
                            </div>
                        </div>
                    `;
                }
            }
            renderGaleriCarousel();


            // ==========================================
            // 2. AMBIL DATA ARTIKEL DARI DATABASE API
            // ==========================================
            function loadDataArtikel() {
                fetch('/api/list-artikel')
                .then(response => response.json())
                .then(res => {
                    listArtikelGlobal = res.data;
                    displayArtikelSesuaiPage();
                })
                .catch(err => {
                    console.error("Gagal memuat artikel:", err);
                    document.getElementById('container-artikel').innerHTML = `<p class="text-center text-danger">Gagal memuat data berita.</p>`;
                });
            }
            loadDataArtikel();

            // ==========================================
            // 3. EVENT ACTION LIHAT ARTIKEL LAINNYA
            // ==========================================
            document.getElementById('btn-view-more').addEventListener('click', function() {
                masukModeArsipArtikel();
            });
        });

        // ==========================================
        // RENDERING & PAGINATION LOGIC CLIENT SIDE
        // ==========================================
        function displayArtikelSesuaiPage() {
            const container = document.getElementById('container-artikel');
            container.innerHTML = '';

            if (!listArtikelGlobal || listArtikelGlobal.length === 0) {
                container.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-newspaper text-muted display-4 mb-3"></i>
                        <p class="text-muted fs-5">Belum ada artikel yang diunggah. Nantikan kabar terbaru dari kami!</p>
                    </div>
                `;
                document.getElementById('btn-view-more').style.display = 'none';
                document.getElementById('pagination-list').innerHTML = '';
                return;
            }

            // Tentukan Limit data berdasarkan status view mode
            const limit = isArsipView ? 10 : 4;
            
            // Hitung Index potong data array
            const startIndex = (currentPage - 1) * limit;
            const endIndex = startIndex + limit;
            const artikelDicetak = listArtikelGlobal.slice(startIndex, endIndex);

            // Sembunyikan atau Tampilkan tombol "Lihat Artikel Lainnya"
            if (isArsipView || listArtikelGlobal.length <= 4) {
                document.getElementById('btn-view-more').style.display = 'none';
            } else {
                document.getElementById('btn-view-more').style.display = 'block';
            }

            // Loop cetak card data
            artikelDicetak.forEach((artikel) => {
                // Cari index asli data di dalam list global untuk keperluan fungsi baca detail
                const originalIndex = listArtikelGlobal.findIndex(a => a.id === artikel.id);
                
                let badgeColor = 'bg-success';
                if(artikel.kategori === 'Opini') badgeColor = 'bg-warning text-dark';
                if(artikel.kategori === 'Pengumuman') badgeColor = 'bg-danger';
                if(artikel.kategori === 'Kisah Santri') badgeColor = 'bg-info text-dark';

                container.innerHTML += `
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm overflow-hidden rounded-3">
                            <div class="row g-0 h-100">
                                <div class="col-md-4 bg-secondary" style="background: url('/api/lihat-gambar-artikel/${artikel.gambar_artikel}') center center/cover; min-height: 180px;"></div>
                                <div class="col-md-8 p-4 d-flex flex-column justify-content-between">
                                    <div>
                                        <span class="badge ${badgeColor} mb-2">${artikel.kategori}</span>
                                        <h5 class="fw-bold card-title mb-2">${artikel.judul}</h5>
                                        <p class="text-muted card-text small mb-3 clamp-text">
                                            ${artikel.konten}
                                        </p>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0)" onclick="bukaDetailArtikel(${originalIndex})" class="text-success fw-bold text-decoration-none small">Baca Selengkapnya →</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            renderPaginationControls(limit);
        }

        function renderPaginationControls(limit) {
            const paginationContainer = document.getElementById('pagination-list');
            paginationContainer.innerHTML = '';

            const totalPages = Math.ceil(listArtikelGlobal.length / limit);
            if (totalPages <= 1) return; // Jika isi artikel kurang dari limit, tidak perlu render tombol page

            // Tombol Previous
            const prevDisabled = currentPage === 1 ? 'disabled' : '';
            paginationContainer.innerHTML += `
                <li class="page-item ${prevDisabled}">
                    <a class="page-link text-success" href="javascript:void(0)" onclick="gantiHalaman(${currentPage - 1})"><i class="fas fa-chevron-left"></i></a>
                </li>
            `;

            // Angka Halaman
            for (let i = 1; i <= totalPages; i++) {
                const activeClass = currentPage === i ? 'active bg-success border-success text-white' : 'text-success';
                const customStyle = currentPage === i ? 'style="background-color: #198754 !important; border-color: #198754 !important; color: white !important;"' : '';
                paginationContainer.innerHTML += `
                    <li class="page-item ${currentPage === i ? 'active' : ''}">
                        <a class="page-link ${activeClass}" ${customStyle} href="javascript:void(0)" onclick="gantiHalaman(${i})">${i}</a>
                    </li>
                `;
            }

            // Tombol Next
            const nextDisabled = currentPage === totalPages ? 'disabled' : '';
            paginationContainer.innerHTML += `
                <li class="page-item ${nextDisabled}">
                    <a class="page-link text-success" href="javascript:void(0)" onclick="gantiHalaman(${currentPage + 1})"><i class="fas fa-chevron-right"></i></a>
                </li>
            `;
        }

        function gantiHalaman(pageTujuan) {
            currentPage = pageTujuan;
            displayArtikelSesuaiPage();
            document.getElementById('berita').scrollIntoView({ behavior: 'smooth' });
        }

        function masukModeArsipArtikel() {
            isArsipView = true;
            currentPage = 1; // reset ke halaman pertama

            // Sembunyikan Landing Banner & Profil, sisakan Berita, Navbar dan Footer
            document.getElementById('section-landing-page').classList.add('d-none');
            document.getElementById('detail-artikel-content').classList.add('d-none');
            document.getElementById('main-homepage-content').classList.remove('d-none');
            
            // Ubah teks judul dan tampilkan tombol kembali ke beranda utama
            document.getElementById('btn-kembali-arsip').classList.remove('d-none');
            document.getElementById('sub-judul-berita').innerText = "Arsip Informasi";
            document.getElementById('judul-berita').innerText = "Seluruh Daftar Berita & Artikel";

            displayArtikelSesuaiPage();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // ==========================================
        // LOGIKA SINGLE PAGE INTERACTIVE BACA ARTIKEL
        // ==========================================
        function bukaDetailArtikel(index) {
            const artikel = listArtikelGlobal[index];
            if (!artikel) return;

            const homepageView = document.getElementById('main-homepage-content');
            const landingView = document.getElementById('section-landing-page');
            const detailView = document.getElementById('detail-artikel-content');

            const kontenFormatHtml = artikel.konten.replace(/\n/g, '<br>');

            detailView.innerHTML = `
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <button onclick="keluarDariDetailArtikel()" class="btn btn-outline-success btn-sm mb-4 fw-bold rounded-pill px-3 shadow-sm">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </button>
                        
                        <div class="mb-3">
                            <span class="badge bg-success px-3 py-2 fs-6 mb-2">${artikel.kategori}</span>
                            <h1 class="display-5 fw-bold text-dark">${artikel.judul}</h1>
                            <p class="text-muted small"><i class="far fa-calendar-alt me-1"></i> Diposting pada: ${new Date(artikel.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}</p>
                        </div>

                        <div class="my-4">
                            <img src="/api/lihat-gambar-artikel/${artikel.gambar_artikel}" class="img-fluid rounded-3 shadow w-100" style="max-height: 480px; object-fit: cover;" alt="${artikel.judul}">
                        </div>

                        <div class="article-body text-secondary fs-5 lh-lg mt-4">
                            ${kontenFormatHtml}
                        </div>
                    </div>
                </div>
            `;

            landingView.classList.add('d-none');
            homepageView.classList.add('d-none');
            detailView.classList.remove('d-none');
            
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function keluarDariDetailArtikel() {
            // Jika sebelumnya dari mode arsip, kembalikan ke arsip, jika bukan kembalikan ke beranda utuh
            if (isArsipView) {
                masukModeArsipArtikel();
            } else {
                kembaliKeBeranda();
            }
        }

        function kembaliKeBeranda(langsungKeBerita = false) {
            isArsipView = false;
            currentPage = 1;

            // Kembalikan semua element profile & hero section
            document.getElementById('section-landing-page').classList.remove('d-none');
            document.getElementById('main-homepage-content').classList.remove('d-none');
            document.getElementById('detail-artikel-content').classList.add('d-none');
            
            // Kembalikan judul semula
            document.getElementById('btn-kembali-arsip').classList.add('d-none');
            document.getElementById('sub-judul-berita').innerText = "Kabar Pesantren";
            document.getElementById('judul-berita').innerText = "Berita & Artikel Terbaru";

            displayArtikelSesuaiPage();
            
            if (langsungKeBerita) {
                document.getElementById('berita').scrollIntoView({ behavior: 'smooth' });
            } else {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }
    </script>
</body>
</html>