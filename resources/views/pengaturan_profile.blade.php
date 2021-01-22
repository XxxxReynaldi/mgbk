@extends('layouts.template_app')

@section('content')

@include('includes.navbar')

<div class="container">
    <div class="columns">
        <div class="column">
            <h1 class="title is-5">Perbarui Profil</h1>
        </div>
    </div>

    <div class="columns is-centered">
        <div class="column is-4">
            <div class="field">
                <label class="label">Nama Lengkap</label>
                <div class="control">
                    <input class="input" type="text" placeholder="Nama Lengkap">
                </div>
            </div>
            <div class="field">
                <label class="label">Foto Profil</label>
                <div class="file has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="resume">
                        <span class="file-cta">
                            <span class="file-icon">
                                <i class="fas fa-upload"></i>
                            </span>
                            <span class="file-label">
                                Pilih file…
                            </span>
                        </span>
                        <span class="file-name">
                            Screen Shot 2017-07-29 at 15.54.25.png
                        </span>
                    </label>
                </div>
            </div>
            <div class="field">
                <label class="label">Asal Sekolah</label>
                <div class="control">
                    <input class="input" type="text" placeholder="Asal Sekolah">
                </div>
            </div>
            <div class="field">
                <label class="label">Logo Sekolah</label>
                <div class="file has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="resume">
                        <span class="file-cta">
                            <span class="file-icon">
                                <i class="fas fa-upload"></i>
                            </span>
                            <span class="file-label">
                                Pilih file…
                            </span>
                        </span>
                        <span class="file-name">
                            Screen Shot 2017-07-29 at 15.54.25.png
                        </span>
                    </label>
                </div>
            </div>
        </div>
        <div class="column is-4">
            <div class="field">
                <label class="label">Alamat Sekolah</label>
                <div class="control">
                    <input class="input" type="text" placeholder="Alamat Sekolah">
                </div>
            </div>
            <div class="field">
                <label class="label">Nama Kepala Sekolah</label>
                <div class="control">
                    <input class="input" type="text" placeholder="Nama Kepala Sekolah">
                </div>
            </div>
            <div class="field">
                <label class="label">Tambahan Informasi</label>
                <div class="control">
                    <input class="input" type="text" placeholder="Tambahan Informasi">
                </div>
            </div>
        </div>
    </div>
    <hr class="divider">
    <div class="columns">
        <div class="column is-2 is-offset-8">
            <div class="field is-grouped is-pulled-right">
                <p class="control">
                    <a href="/lihat-profil.html" class="button is-light">Batal</a>
                </p>
                <p class="control">
                    <a href="#" class="button is-success">Simpan</a>
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
