<nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top navbar-fixed-top" data-aos="fade-down"
    aria-label="Navbar">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="images/logo2.svg" alt="" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="ml-auto navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('categories') }}">Categories</a>
                </li>
            </ul>

            <!-- Desktop Menu -->
            <ul class="navbar-nav d-none d-lg-flex">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="/images/icon-user.png" alt="" class="mr-2 rounded-circle profile-picture" />
                        Hi, {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
                        <a class="dropdown-item" href="{{ route('dashboard-settings-account') }}">Pengaturan</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="mt-2 nav-link d-inline-block" href="#">
                        <img src="/images/icon-cart-empty.svg" alt="" />
                    </a>
                </li>
            </ul>

            <!-- Mobile Menu -->
            <ul class="navbar-nav d-block d-lg-none">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">Hi, {{ Auth::user()->name }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-inline-block" href="{{ route('cart') }}">Cart</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
