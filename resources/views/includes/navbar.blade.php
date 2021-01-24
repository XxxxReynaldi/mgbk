<nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="#">
            <span class="subtitle"><strong>MGBK Malang</strong></span>
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarTop">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarTop" class="navbar-menu">
        <div class="navbar-end mr-4">
            <a class="navbar-item" href="{{ route('home') }}">
                <span class="icon">
                    <i class="fas fa-home"></i>
                </span>
                <span>
                    Home
                </span>
            </a>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    <span class="icon">
                        <i class="fas fa-cogs"></i>
                    </span>
                    <span>
                        Master
                    </span>
                </a>

                <div class="navbar-dropdown is-right">
                    <a class="navbar-item" href="{{ route('kegiatan.index') }}">
                        Kegiatan
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="{{ route('week.index') }}">
                        Week
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="{{ route('sekolah.index') }}">
                        Sekolah
                    </a>
                </div>
            </div>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    <span class="icon">
                        <i class="fas fa-sticky-note"></i>
                    </span>
                    <span>
                        Laporan
                    </span>
                </a>

                <div class="navbar-dropdown is-right">
                    <a class="navbar-item" href="/laporan-harian.html">
                        Harian
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="/laporan-mingguan.html">
                        Mingguan
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="/laporan-bulanan.html">
                        Bulanan
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="/laporan-semesteran.html">
                        Semesteran
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="/laporan-tahunan.html">
                        Tahunan
                    </a>
                </div>
            </div>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    <span class="icon">
                        <i class="fas fa-user-circle"></i>
                    </span>
                    <span>
                        Profil
                    </span>
                </a>

                <div class="navbar-dropdown is-right">
                    <a class="navbar-item" href="/profil.html">
                        <span class="icon">
                            <i class="fas fa-user"></i>
                        </span>
                        <span>
                            Lihat Profil
                        </span>
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item has-text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <span class="icon">
                            <i class="fas fa-sign-out-alt"></i>
                        </span>
                        <span>
                            Sign Out
                        </span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>