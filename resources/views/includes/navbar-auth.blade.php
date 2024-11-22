<nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top navbar-fixed-top" data-aos="fade-down">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand">
            <img src="/images/logo.svg" alt="Logo" />
            <span class="ml-2">
                <span style="color: #000000;">Yamyam</span><span style="color: #f8c04e; font-weight:">Snack</span>
            </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="ml-auto navbar-nav">
                <li class="nav-item active">
                    <a href="{{ route('home') }}" class="nav-link">Beranda</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categories') }}" class="nav-link">Kategori</a>
                </li>
            </ul>
        </div>
    </div>
</nav>