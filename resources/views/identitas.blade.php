@extends('layouts.app')

@section('title', 'Identitas Pengembang')
@section('icon', 'fa-user-tie')

@section('content')
<div class="container-fluid">
    <!-- Developer Profile Start -->
    <div class="py-4">
        <div class="container py-4">
            <!-- Header dengan breadcrumb -->
            <div class="row mb-4">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Identitas Pengembang</li>
                        </ol>
                    </nav>
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="mb-0">
                            <i class="fas fa-user-tie me-2 text-primary"></i>Identitas Pengembang
                        </h1>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Developer Information -->
                <div class="col-lg-8">
                    <div class="card glass-effect mb-4">
                        <div class="card-body">
                            <h3 class="mb-4">Profil Pengembang Sistem</h3>
                            <p class="mb-4 text-muted">Berikut adalah informasi mengenai pengembang platform UMKM yang bertanggung jawab dalam pembuatan dan pengembangan sistem ini.</p>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-3 rounded shadow-sm bg-white">
                                        <div class="bg-primary rounded-circle p-3 me-3 shadow">
                                            <i class="fas fa-user fa-lg text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Nama Lengkap</h6>
                                            <p class="mb-0 text-primary fs-5">Oza Okta Gistrada</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-3 rounded shadow-sm bg-white">
                                        <div class="bg-secondary rounded-circle p-3 me-3 shadow">
                                            <i class="fas fa-id-card fa-lg text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">NIM</h6>
                                            <p class="mb-0 text-secondary fs-5">2457301117</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-3 rounded shadow-sm bg-white">
                                        <div class="bg-primary rounded-circle p-3 me-3 shadow">
                                            <i class="fas fa-graduation-cap fa-lg text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Program Studi</h6>
                                            <p class="mb-0 text-primary fs-5">Sistem Informasi</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-3 rounded shadow-sm bg-white">
                                        <div class="bg-secondary rounded-circle p-3 me-3 shadow">
                                            <i class="fas fa-university fa-lg text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Perguruan Tinggi</h6>
                                            <p class="mb-0 text-secondary fs-5">Politeknik Caltex Riau</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-3 rounded shadow-sm bg-white">
                                        <div class="bg-primary rounded-circle p-3 me-3 shadow">
                                            <i class="fas fa-envelope fa-lg text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Email</h6>
                                            <p class="mb-0 text-primary">oza24si@mahasiswa.pcr.ac.id</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-3 rounded shadow-sm bg-white">
                                        <div class="bg-secondary rounded-circle p-3 me-3 shadow">
                                            <i class="fas fa-phone fa-lg text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Telepon</h6>
                                            <p class="mb-0 text-secondary">+62 895 0564 7628</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex align-items-center p-3 rounded shadow-sm bg-white">
                                        <div class="bg-primary rounded-circle p-3 me-3 shadow">
                                            <i class="fas fa-map-marker-alt fa-lg text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Alamat</h6>
                                            <p class="mb-0 text-primary">Duri, Riau, Indonesia</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Skills & Expertise -->
                    <div class="card glass-effect mb-4">
                        <div class="card-body">
                            <h3 class="mb-4">Keahlian Teknis</h3>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="skill-item p-3 rounded shadow-sm bg-white">
                                        <h6 class="mb-2">Laravel Framework</h6>
                                        <div class="progress mb-2 shadow-sm">
                                            <div class="progress-bar bg-primary" style="width: 92%"></div>
                                        </div>
                                        <small class="text-muted">92%</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="skill-item p-3 rounded shadow-sm bg-white">
                                        <h6 class="mb-2">Vue.js & JavaScript</h6>
                                        <div class="progress mb-2 shadow-sm">
                                            <div class="progress-bar bg-secondary" style="width: 88%"></div>
                                        </div>
                                        <small class="text-muted">88%</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="skill-item p-3 rounded shadow-sm bg-white">
                                        <h6 class="mb-2">MySQL Database</h6>
                                        <div class="progress mb-2 shadow-sm">
                                            <div class="progress-bar bg-primary" style="width: 90%"></div>
                                        </div>
                                        <small class="text-muted">90%</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="skill-item p-3 rounded shadow-sm bg-white">
                                        <h6 class="mb-2">API Development</h6>
                                        <div class="progress mb-2 shadow-sm">
                                            <div class="progress-bar bg-secondary" style="width: 85%"></div>
                                        </div>
                                        <small class="text-muted">85%</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="skill-item p-3 rounded shadow-sm bg-white">
                                        <h6 class="mb-2">Bootstrap & CSS</h6>
                                        <div class="progress mb-2 shadow-sm">
                                            <div class="progress-bar bg-primary" style="width: 95%"></div>
                                        </div>
                                        <small class="text-muted">95%</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="skill-item p-3 rounded shadow-sm bg-white">
                                        <h6 class="mb-2">Git & Version Control</h6>
                                        <div class="progress mb-2 shadow-sm">
                                            <div class="progress-bar bg-secondary" style="width: 87%"></div>
                                        </div>
                                        <small class="text-muted">87%</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Project Experience -->
                    <div class="card glass-effect mb-4">
                        <div class="card-body">
                            <h3 class="mb-4">Pengalaman Proyek</h3>
                            <div class="timeline">
                                <div class="timeline-item mb-3 p-3 rounded shadow-sm bg-white">
                                    <h5 class="text-primary mb-1">Sistem Informasi UMKM Desa</h5>
                                    <p class="text-muted mb-2"><small>Februari 2024 - Sekarang</small></p>
                                    <p class="mb-0">Mengembangkan platform digital untuk memfasilitasi UMKM lokal dalam memasarkan produk dan mengelola bisnis secara online.</p>
                                </div>
                                <div class="timeline-item mb-3 p-3 rounded shadow-sm bg-white">
                                    <h5 class="text-primary mb-1">Aplikasi E-Commerce</h5>
                                    <p class="text-muted mb-2"><small>Oktober 2023 - Januari 2024</small></p>
                                    <p class="mb-0">Membangun sistem e-commerce dengan fitur pembayaran digital dan manajemen inventaris otomatis.</p>
                                </div>
                                <div class="timeline-item p-3 rounded shadow-sm bg-white">
                                    <h5 class="text-primary mb-1">Sistem Manajemen Sekolah</h5>
                                    <p class="text-muted mb-2"><small>Juni 2023 - September 2023</small></p>
                                    <p class="mb-0">Mengembangkan aplikasi web untuk manajemen data siswa, guru, dan administrasi sekolah.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- About Developer -->
                    <div class="card glass-effect">
                        <div class="card-body">
                            <h3 class="mb-3">Tentang Saya</h3>
                            <p class="mb-3">Saya adalah seorang Full Stack Developer dengan fokus pada pengembangan aplikasi web menggunakan Laravel dan Vue.js. Memiliki pengalaman lebih dari 2 tahun dalam membangun sistem informasi untuk berbagai sektor.</p>
                            <p class="mb-3">Platform UMKM ini dikembangkan dengan tujuan membantu pelaku usaha kecil dan menengah dalam mengembangkan bisnis mereka melalui teknologi digital. Saya percaya bahwa teknologi dapat menjadi alat yang powerful untuk memberdayakan ekonomi lokal.</p>
                            <p class="mb-0">Selama pengembangan proyek ini, saya berfokus pada pembuatan sistem yang user-friendly, scalable, dan aman untuk memastikan pengalaman terbaik bagi semua pengguna.</p>
                        </div>
                    </div>
                </div>

                <!-- Developer Photo & Social Media -->
                <div class="col-lg-4">
                    <div class="card glass-effect mb-4">
                        <div class="card-body text-center">
                            <div class="developer-photo mb-4">
                                @php
                                    // Cek apakah foto ada di public folder
                                    $photoPath = 'assets-admin/assets/img/oza-okta.jpeg';
                                    $photoExists = file_exists(public_path($photoPath));

                                    if ($photoExists) {
                                        $photoUrl = asset($photoPath);
                                    } else {
                                        // Gunakan placeholder dengan nama Anda
                                        $photoUrl = 'https://ui-avatars.com/api/?name=Oza+Okta&background=0d6efd&color=fff&size=250&bold=true';
                                    }
                                @endphp

                                <img src="{{ $photoUrl }}"
                                     class="img-fluid rounded-circle border border-4 border-primary shadow mb-3"
                                     alt="Oza Okta Gistrada"
                                     style="width: 180px; height: 180px; object-fit: cover;"
                                     onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Oza+Okta&background=0d6efd&color=fff&size=250&bold=true';">

                                @if(!$photoExists)
                                <div class="alert alert-info mt-2 py-1 px-2 small">
                                    <i class="fas fa-info-circle"></i>
                                    <small>Untuk menambahkan foto, simpan di: <code>public/assets-admin/assets/img/developers/</code></small>
                                </div>
                                @endif
                            </div>

                            <h4 class="mb-2">Oza Okta Gistrada</h4>
                            <p class="text-muted mb-3"><small>Full Stack Developer & System Architect</small></p>

                            <!-- Social Media Links -->
                            <div class="social-links mb-4">
                                <h5 class="mb-3">Hubungi Saya</h5>
                                <div class="d-flex justify-content-center flex-wrap gap-2">
                                    <a href="https://www.linkedin.com/in/oza-oza-okta-427826356/"
                                       class="btn btn-outline-primary btn-sm"
                                       target="_blank"
                                       title="LinkedIn">
                                        <i class="fab fa-linkedin-in me-1"></i> LinkedIn
                                    </a>
                                    <a href="https://github.com/zennn187/"
                                       class="btn btn-outline-secondary btn-sm"
                                       target="_blank"
                                       title="GitHub">
                                        <i class="fab fa-github me-1"></i> GitHub
                                    </a>
                                    <a href="https://instagram.com/oza.oktaa"
                                       class="btn btn-outline-primary btn-sm"
                                       target="_blank"
                                       title="Instagram">
                                        <i class="fab fa-instagram me-1"></i> Instagram
                                    </a>
                                    <a href="https://wa.me/6289505647628?text=Halo,%20saya%20tertarik%20dengan%20produk%20Anda"
                                       class="btn btn-outline-success btn-sm"
                                       target="_blank"
                                       title="WhatsApp">
                                        <i class="fab fa-whatsapp me-1"></i> WhatsApp
                                    </a>
                                </div>
                            </div>

                            <div class="contact-info">
                                <div class="d-flex align-items-center mb-2 p-2 rounded shadow-sm bg-white small">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    <span>Jl. Budi Sari No. 18, Pekanbaru</span>
                                </div>
                                <div class="d-flex align-items-center mb-2 p-2 rounded shadow-sm bg-white small">
                                    <i class="fas fa-globe text-primary me-2"></i>
                                    <a href="https://oza.oktaa" class="text-decoration-none" target="_blank">https://oza.oktaa</a>
                                </div>
                                <div class="d-flex align-items-center p-2 rounded shadow-sm bg-white small">
                                    <i class="fas fa-calendar-alt text-primary me-2"></i>
                                    <span>Bergabung sejak: Januari 2024</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Technologies Used -->
                    <div class="card glass-effect mb-4">
                        <div class="card-body">
                            <h5 class="mb-3">Teknologi yang Digunakan</h5>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="tech-item p-2 rounded shadow-sm bg-white text-center">
                                        <i class="fab fa-laravel fa-2x text-danger mb-1"></i>
                                        <h6 class="mb-0 small">Laravel</h6>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="tech-item p-2 rounded shadow-sm bg-white text-center">
                                        <i class="fab fa-vuejs fa-2x text-success mb-1"></i>
                                        <h6 class="mb-0 small">Vue.js</h6>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="tech-item p-2 rounded shadow-sm bg-white text-center">
                                        <i class="fab fa-bootstrap fa-2x text-purple mb-1"></i>
                                        <h6 class="mb-0 small">Bootstrap</h6>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="tech-item p-2 rounded shadow-sm bg-white text-center">
                                        <i class="fas fa-database fa-2x text-info mb-1"></i>
                                        <h6 class="mb-0 small">MySQL</h6>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="tech-item p-2 rounded shadow-sm bg-white text-center">
                                        <i class="fab fa-git-alt fa-2x text-orange mb-1"></i>
                                        <h6 class="mb-0 small">Git</h6>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="tech-item p-2 rounded shadow-sm bg-white text-center">
                                        <i class="fab fa-docker fa-2x text-blue mb-1"></i>
                                        <h6 class="mb-0 small">Docker</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="card glass-effect">
                        <div class="card-body">
                            <h5 class="mb-3">Link Cepat</h5>
                            <div class="d-flex flex-column">
                                <a href="https://github.com/zennn187/umkm-admin"
                                   class="btn btn-outline-secondary mb-2 shadow-sm"
                                   target="_blank">
                                    <i class="fab fa-github me-2"></i> Repository Proyek
                                </a>
                                <a href="mailto:oza24si@mahasiswa.pcr.ac.id"
                                   class="btn btn-outline-primary mb-2 shadow-sm">
                                    <i class="fas fa-paper-plane me-2"></i> Kirim Email
                                </a>
                                <a href="{{ route('dashboard') }}"
                                   class="btn btn-outline-primary shadow-sm">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Developer Profile End -->
</div>
@endsection

@section('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
    }

    .timeline-item {
        position: relative;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -38px;
        top: 50%;
        transform: translateY(-50%);
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--primary-color);
        border: 3px solid white;
        box-shadow: 0 0 0 3px var(--primary-color);
    }

    .tech-item {
        transition: all 0.3s ease;
    }

    .tech-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
    }

    .skill-item {
        transition: all 0.3s ease;
    }

    .skill-item:hover {
        transform: translateY(-2px);
    }

    /* Progress bar animation */
    .progress-bar {
        animation: progress-animation 1.5s ease-out;
    }

    @keyframes progress-animation {
        0% { width: 0; }
        100% { width: attr(style); }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate progress bars when page loads
        setTimeout(() => {
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.width = width;
                }, 300);
            });
        }, 500);

        // Hover effect for timeline items
        const timelineItems = document.querySelectorAll('.timeline-item');
        timelineItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(5px)';
            });

            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });

        // Hover effect for contact info items
        const contactItems = document.querySelectorAll('.contact-info > div');
        contactItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.1)';
            });

            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '';
            });
        });
    });
</script>
@endsection
