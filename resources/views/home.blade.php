@extends('layouts.template_app')

@section('content')

@include('includes.navbar')

<div class="container">
    <div class="columns">
        <div class="column">
            <h1 class="title is-5">Quick Access</h1>
        </div>
    </div>
    <div class="columns is-multiline">
        <div class="column is-4">
            <div class="card white-blue">
                <header class="card-header">
                    <p class="card-header-title">
                        Lihat Laporan
                    </p>
                </header>
                <div class="card-content">
                    <div class="content">
                        Lihat tabel laporan berdasarkan periode
                    </div>
                </div>
                <footer class="card-footer">
                    <a href="/laporan-harian.html" class="card-footer-item">
                        Harian
                    </a>
                    <a href="/laporan-harian.html" class="card-footer-item">
                        Mingguan
                    </a>
                    <a href="/laporan-harian.html" class="card-footer-item">
                        Bulanan
                    </a>
                    <a href="/laporan-harian.html" class="card-footer-item">
                        Tahunan
                    </a>
                </footer>
            </div>
        </div>
        <div class="column is-4">
            <div class="card white-blue">
                <header class="card-header">
                    <p class="card-header-title">
                        Verifikasi Sekolah
                    </p>
                </header>
                <div class="card-content">
                    <div class="content">
                        Verifikasi sekolah yang belum terdaftar.
                    </div>
                </div>
                <footer class="card-footer">
                    <a href="{{ route('sekolah_baru.index') }}" class="card-footer-item">
                        Verifikasi
                    </a>
                </footer>
            </div>
        </div>
    </div>
</div>
@endsection
