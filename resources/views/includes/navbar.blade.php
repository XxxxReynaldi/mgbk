@if (auth()->user()->user_level == 1)
<nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="{{ route('home') }}">
            <span class="subtitle"><strong>MGBK SMA Kota Malang</strong></span>
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
                    <a class="navbar-item" href="{{ route('admin.kegiatan.index') }}">
                        Kegiatan
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="{{ route('admin.week.index') }}">
                        Week
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="{{ route('admin.sekolah.index') }}">
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
                    <a class="navbar-item" href="{{ route('admin.laporan.harian') }}">
                        Harian
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="{{ route('admin.laporan.mingguan') }}">
                        Mingguan
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="{{ route('admin.laporan.bulanan') }}">
                        Bulanan
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="{{ route('admin.laporan.semesteran') }}">
                        Semesteran
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="{{ route('admin.laporan.tahunan') }}">
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
                    <a class="navbar-item" href="{{ route('profile.index') }}">
                        <span class="icon">
                            <i class="fas fa-user"></i>
                        </span>
                        <span>
                            Lihat Profil
                        </span>
                    </a>
                    <a class="navbar-item" href="{{ route('update-password.edit')}}">
                        <span class="icon">
                            <i class="fas fa-lock"></i>
                        </span>
                        <span>
                            Ubah Password
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

@elseif (auth()->user()->user_level == 2)

<nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="{{ route('home') }}">
            <span class="subtitle"><strong>MGBK SMA Kota Malang</strong></span>
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
            {{-- <a class="navbar-item" href="/buat-laporan.html">
                <span class="icon">
                    <i class="fas fa-plus"></i>
                </span>
                <span>
                    Buat Laporan
                </span>
            </a> --}}
            @if ($profile == null)
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link notifProfileDanger">
                        <span class="icon">
                            <i class="fas fa-sticky-note"></i>
                        </span>
                        <span>
                            Laporan
                        </span>
                    </a>
                </div>
            @else
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
                        <a class="navbar-item" href="{{ route('user.laporan.harian') }}">
                            Harian
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" href="{{ route('user.laporan.mingguan') }}">
                            Mingguan
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" href="{{ route('user.laporan.bulanan') }}">
                            Bulanan
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" href="{{ route('user.laporan.semesteran') }}">
                            Semesteran
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" href="{{ route('user.laporan.tahunan') }}">
                            Tahunan
                        </a>
                        {{-- <hr class="navbar-divider"> --}}
                        {{-- <a class="navbar-item" href="{{ route('user.laporan.harian') }}">
                            <span class="icon">
                                <i class="fas fa-book-open"></i>
                            </span>
                            <span>
                                Lihat Laporan
                            </span>
                        </a> --}}
                    </div>
                </div>
            @endif
            
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
                    <a class="navbar-item" href="{{ route('profile.index') }}">
                        <span class="icon">
                            <i class="fas fa-user"></i>
                        </span>
                        <span>
                            Lihat Profil
                        </span>
                    </a>
                    <a class="navbar-item" href="{{ route('update-password.edit')}}">
                        <span class="icon">
                            <i class="fas fa-lock"></i>
                        </span>
                        <span>
                            Ubah Password
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

@endif
