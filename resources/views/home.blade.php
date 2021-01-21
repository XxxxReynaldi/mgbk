@extends('layouts.template_app')

@section('content')

<div class="container">
    <div class="columns">
        <div class="column">
            <h1 class="title is-5">Quick Access</h1>
        </div>
    </div>
    <div class="columns is-multiline">
        <div class="column is-4">
            <div class="card">
                <header class="card-header">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p class="card-header-title">
                        Lengkapi Profil
                    </p>
                </header>
                <div class="card-content">
                    <div class="content">
                        Lengkapi profil sebelum mengirimkan laporan.
                    </div>
                </div>
                <footer class="card-footer">
                    <a href="#" class="card-footer-item">
                        <span>
                            Mulai
                        </span>
                        <span class="icon">
                            <i class="fas fa-long-arrow-alt-right"></i>
                        </span>
                    </a>
                </footer>
            </div>
        </div>
        <div class="column is-4">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        Buat Laporan
                    </p>
                </header>
                <div class="card-content">
                    <div class="content">
                        Buat laporan kegiatan untuk dikirimkan.
                    </div>
                </div>
                <footer class="card-footer">
                    <a href="#" class="card-footer-item">
                        <span>
                            Mulai
                        </span>
                        <span class="icon">
                            <i class="fas fa-long-arrow-alt-right"></i>
                        </span>
                    </a>
                </footer>
            </div>
        </div>
        <div class="column is-4">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        Cetak Laporan
                    </p>
                </header>
                <div class="card-content">
                    <div class="content">
                        Cetak laporan kegiatan.
                    </div>
                </div>
                <footer class="card-footer">
                    <a href="#" class="card-footer-item">
                        <span>
                            Mulai
                        </span>
                        <span class="icon">
                            <i class="fas fa-long-arrow-alt-right"></i>
                        </span>
                    </a>
                </footer>
            </div>
        </div>
    </div>
</div>
@endsection
