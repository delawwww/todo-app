@if (Request::is('/'))  <!-- Cek apakah berada di halaman utama -->

<!-- Navbar Header dengan Background dan Profil -->
<nav class="navbar">
    <!-- Background Header -->
    <img src="images/background.jpg" 
         alt="Header Background" 
         style="position: absolute; 
                top: 0; left: 0; 
                width: 100%; height: 100%; 
                object-fit: cover; 
                object-position: center;
                z-index: -1;"> <!-- Z-index agar background tetap di belakang navbar -->

    <!-- Kontainer Profil -->
    <div class="container-fluid d-flex flex-column align-items-center justify-content-center text-white" style="height: 250px;">
        <!-- Foto Profil -->
                <img src="{{ asset('images/profileweb.jpg') }}" 
                alt="Profile Picture" 
                style="width: 100px; height: 100px; border-radius: 50%; border: 4px solid white; object-fit: cover;" 
                class="">
             
        <!-- Nama Pengguna -->
        <h2 class="mt-2">Dela Novela</h2>
    </div>
</nav>
<!-- Navbar Utama -->
<nav class="navbar navbar-expand-lg bg-info navbar-dark px-3">
    <div class="container-fluid">
        <!-- Link untuk nama aplikasi -->
        <a class="navbar-brand fw-bolder d-flex align-items-center gap-2">
            <i class="bi bi-card-checklist"></i> <!-- Ikon aplikasi -->
            {{ config('app.name') }} <!-- Nama aplikasi yang diambil dari konfigurasi -->
        </a>
    </div>
    <div class="container-fluid">
        <div class="d-flex ms-auto"> 
            <!-- Input pencarian dengan tombol Search dan Fresh -->
        <form class="d-flex" action="{{ route('search') }}" method="GET" role="search">
            <input id="search-input" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-light" type="button" onclick="window.location.reload();">Refresh</button>
        </form>
        </div>
    </div>
</nav>
@endif