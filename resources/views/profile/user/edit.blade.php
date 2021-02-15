@extends('layouts.template_app')

@section('content')

@include('includes.navbar')

<div class="container">
    <div class="columns">
        <div class="column">
            <h1 class="title is-5">Perbarui Profil</h1>
        </div>
    </div>

    @if (session('status'))
        <div class="notification is-info column is-5">
            <button class="delete deleteNotif"></button>
            {{ session('status') }}
        </div>
    @else 
        @if($errors->any())
        <div class="notification is-danger column is-5">
            <button class="delete deleteNotif"></button>
            @foreach ($errors->all() as $error)
            {{ $error }} <br/>
            @endforeach
        </div>
        @endif
    @endif

    @if ($checkProfile)
        <form method="POST" action="{{ url('profile', ['id_profile' => $profile->id_profile]) }}" id="editForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="columns is-centered">
                <div class="column is-4">
                    <div class="field">
                        <label class="label">Nama Lengkap</label>
                        <div class="control">
                            <input value="{{ $profile->nama_lengkap }}" name="nama_lengkap" class="input @error('nama_lengkap') is-invalid @enderror" type="text" placeholder="Nama Lengkap">
                        </div>
                        @error('nama_lengkap')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="label">Foto Profil</label>
                        <div class="file has-name">
                            <label class="file-label">
                                <input class="file-input @error('foto_profil') is-invalid @enderror" type="file" name="foto_profil" value="{{ $profile->foto_profil }}">
                                <span class="file-cta">
                                    <span class="file-icon">
                                        <i class="fas fa-upload"></i>
                                    </span>
                                    <span class="file-label">
                                        Pilih file…
                                    </span>
                                </span>
                                <span class="file-name">
                                    {{ $profile->foto_profil }}
                                </span>
                            </label>
                        </div>
                        @error('foto_profil')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="label">Asal Sekolah</label>
                        <div class="control">
                            <select class="select-school @error('asal_sekolah') is-invalid @enderror" style="width: 100%" name="id_sekolah" data-placeholder="Pilih Sekolah">
                                <option value="{{ $profile->id_sekolah }}">Alabama</option>
                            </select>
                        </div>
                        @error('asal_sekolah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="label">Logo Sekolah</label>
                        <div class="file has-name">
                            <label class="file-label">
                                <input class="file-input @error('logo_sekolah') is-invalid @enderror" type="file" name="logo_sekolah" value="{{ $profile->logo_sekolah }}">
                                <span class="file-cta">
                                    <span class="file-icon">
                                        <i class="fas fa-upload"></i>
                                    </span>
                                    <span class="file-label">
                                        Pilih file…
                                    </span>
                                </span>
                                <span class="file-name">
                                    {{ $profile->logo_sekolah }}
                                </span>
                            </label>
                        </div>
                        @error('logo_sekolah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="column is-4">
                    <div class="field">
                        <label class="label">Alamat Sekolah</label>
                        <div class="control">
                            <input value="{{ $profile->alamat_sekolah }}" name="alamat_sekolah" class="input @error('alamat_sekolah') is-invalid @enderror" type="text" placeholder="Alamat Sekolah">
                        </div>
                        @error('alamat_sekolah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="label">Nama Kepala Sekolah</label>
                        <div class="control">
                            <input value="{{ $profile->nama_kepala_sekolah }}" name="nama_kepala_sekolah" class="input @error('nama_kepala_sekolah') is-invalid @enderror" type="text" placeholder="Nama Kepala Sekolah">
                        </div>
                        @error('nama_kepala_sekolah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="label">Tambahan Informasi</label>
                        <div class="control">
                            <input value="{{ $profile->tambahan_informasi }}" name="tambahan_informasi" class="input @error('tambahan_informasi') is-invalid @enderror" type="text" placeholder="Tambahan Informasi">
                        </div>
                        @error('tambahan_informasi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <hr class="divider">
            <div class="columns">
                <div class="column is-2 is-offset-8">
                    <div class="field is-grouped is-pulled-right">
                        {{-- <p class="control">
                            <a href="/lihat-profil.html" class="button is-light">Batal</a>
                        </p> --}}
                        <p class="control">
                            <button type="submit" class="button is-success">Simpan</button>
                        </p>
                    </div>
                </div>
            </div>
        </form>
    @else
        <form method="POST" action="{{ route('profile.store') }}" id="addForm" enctype="multipart/form-data">
            @csrf
            <div class="columns is-centered">
                <div class="column is-4">
                    <div class="field">
                        <label class="label">Nama Lengkap</label>
                        <div class="control">
                            <input class="input @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" type="text" placeholder="Nama Lengkap">
                        </div>
                        @error('nama_lengkap')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="label">Foto Profil</label>
                        <div class="file has-name">
                            <label class="file-label">
                                <input class="file-input @error('foto_profil') is-invalid @enderror" type="file" name="foto_profil">
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
                        @error('foto_profil')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="label">Asal Sekolah</label>
                        <div class="control">
                            <select class="select-school @error('asal_sekolah') is-invalid @enderror" style="width: 100%" name="id_sekolah" data-placeholder="Pilih Sekolah">
                                <option value="1">Alabama</option>
                            </select>
                        </div>
                        @error('asal_sekolah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="label">Logo Sekolah</label>
                        <div class="file has-name">
                            <label class="file-label">
                                <input class="file-input @error('logo_sekolah') is-invalid @enderror" type="file" name="logo_sekolah">
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
                        @error('logo_sekolah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="column is-4">
                    <div class="field">
                        <label class="label">Alamat Sekolah</label>
                        <div class="control">
                            <input class="input @error('alamat_sekolah') is-invalid @enderror" name="alamat_sekolah" type="text" placeholder="Alamat Sekolah">
                        </div>
                        @error('alamat_sekolah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="label">Nama Kepala Sekolah</label>
                        <div class="control">
                            <input class="input @error('nama_kepala_sekolah') is-invalid @enderror" name="nama_kepala_sekolah" type="text" placeholder="Nama Kepala Sekolah">
                        </div>
                        @error('nama_kepala_sekolah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="label">Tambahan Informasi</label>
                        <div class="control">
                            <input class="input @error('tambahan_informasi') is-invalid @enderror" name="tambahan_informasi" type="text" placeholder="Tambahan Informasi">
                        </div>
                        @error('tambahan_informasi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <hr class="divider">
            <div class="columns">
                <div class="column is-2 is-offset-8">
                    <div class="field is-grouped is-pulled-right">
                        {{-- <p class="control">
                            <a href="/lihat-profil.html" class="button is-light">Batal</a>
                        </p> --}}
                        <p class="control">
                            <button type="submit" class="button is-success">Simpan</button>
                        </p>
                    </div>
                </div>
            </div>
        </form>
    @endif
    
</div>

<script>
    $(document).ready(function() {
        $('.select-school').select2();
    });
</script>

@endsection
