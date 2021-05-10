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

        @if (auth()->user()->user_level == 1)
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
                        <a href="{{ route('admin.laporan.harian') }}" class="card-footer-item">
                            Harian
                        </a>
                        <a href="{{ route('admin.laporan.mingguan') }}" class="card-footer-item">
                            Mingguan
                        </a>
                        <a href="{{ route('admin.laporan.bulanan') }}" class="card-footer-item">
                            Bulanan
                        </a>
                        <a href="{{ route('admin.laporan.tahunan') }}" class="card-footer-item">
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
                        <a href="{{ route('new_sekolah.index') }}" class="card-footer-item">
                            Verifikasi
                        </a>
                    </footer>
                </div>
            </div>
        @elseif (auth()->user()->user_level == 2)
            <div class="column is-4">
                <div class="card">
                    <header class="card-header">
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
                        <a href="{{ route('profile.index') }}" class="card-footer-item">
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
                <input type="hidden" id="sekolah" name="id_sekolah" value="{{ $profile == null ? null : $profile->id_sekolah }}">
                <input type="hidden" id="guru" name="id_user" value="{{ Auth::user()->id_user }}">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            Buat Laporan
                        </p>
                    </header>
                    <div class="card-content">
                        <div class="content">
                            Import laporan kegiatan untuk dikirimkan.
                        </div>
                    </div>
                    <footer class="card-footer">
                        @if ($profile == null )
                        <a class="card-footer-item notifProfileDanger">
                            <span>
                                Mulai
                            </span>
                            <span class="icon">
                                <i class="fas fa-long-arrow-alt-right"></i>
                            </span>
                        </a>   
                        @else
                            <a class="card-footer-item importBtn">
                                <span>
                                    Mulai
                                </span>
                                <span class="icon">
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                </span>
                            </a>    
                        @endif
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
                        @if ($profile == null)
                            <a class="card-footer-item notifProfileDanger">
                                <span>
                                    Mulai
                                </span>
                                <span class="icon">
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                </span>
                            </a>  
                        @else
                            <a href="{{ route('user.laporan.harian') }}" class="card-footer-item">
                                Harian
                            </a>
                            <a href="{{ route('user.laporan.mingguan') }}" class="card-footer-item">
                                Mingguan
                            </a>
                            <a href="{{ route('user.laporan.bulanan') }}" class="card-footer-item">
                                Bulanan
                            </a>
                            <a href="{{ route('user.laporan.semesteran') }}" class="card-footer-item">
                                Semesteran
                            </a>
                            <a href="{{ route('user.laporan.tahunan') }}" class="card-footer-item">
                                Tahunan
                            </a>    
                        @endif
                        
                    </footer>
                </div>
            </div>

            <div class="modal" id="modal_import">
                <div class="modal-background"></div>
                <div class="modal-card">
                  <header class="modal-card-head">
                    <p class="modal-card-title">
                        <span class="icon-text has-text-info">
                            <span class="icon">
                                <i class="fas fa-file-excel"></i>  
                            </span>
                            <span>Import Data laporan</span>
                        </span>
                    </p>
                    <button class="delete modal-closed" aria-label="close"></button>
                  </header>
                  <form method="post" action="{{ route('user.laporan.import') }}" id="importForm" enctype="multipart/form-data">
                    <section class="modal-card-body">
                        @csrf
                        <input type="hidden" name="id_sekolah" value="">
                        <input type="hidden" name="id_user" value="">
                        <div class="field">
                            <h3><label class="label" >Peringatan ! </label></h3>
                            <p>Sebelum anda mengimport file excelnya pastikan anda sudah mendownload File excel sesuai dengan format kami, 
                                anda bisa mendownloadnya <a href="{{ route('user.laporan.exportActivity') }}" target="_self">disini!</a>
                            </p>
                        </div>
                        <div class="field">
                            <label class="label" >File Excel</label>
                            <div id="file-js-example" class="file has-name">
                                <label class="file-label">
                                    <input class="file-input" type="file" name="file_excel_report" required>
                                    <span class="file-cta">
                                    <span class="file-icon">
                                        <i class="fas fa-upload"></i>
                                    </span>
                                    <span class="file-label">
                                        Choose a file…
                                    </span>
                                    </span>
                                    <span class="file-name">
                                    No file uploaded
                                    </span>
                                </label>
                            </div>
                            <p class="help">format yang diperbolehkan xls, xlsx .</p>
                        </div>
                    </section>
                        <footer class="modal-card-foot">
                            <button type="submit" class="button is-link">Import</button>
                            <a href="#" class="button modal-closed">Batal</a> 
                        </footer>
                    </form>
                </div>
            </div>
        @endif
        
    </div>
</div>

<script>
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.modal-closed').on('click', function () {
            $('#modal_import').removeClass('is-active');
        })

        $('.deleteNotif').on('click', function () {
            $('.notification').addClass('is-hidden')
        })    

        const fileInput = document.querySelector('#file-js-example input[type=file]');
        fileInput.onchange = () => {
            if (fileInput.files.length > 0) {
            const fileName = document.querySelector('#file-js-example .file-name');
            fileName.textContent = fileInput.files[0].name;
            }
        }

        let id_sekolah      = $('#sekolah').val();
        let id_user         = $('#guru').val();

        $('.importBtn').click(function () {
            $('#modal_import').addClass('is-active');
            $('input[name=id_sekolah]').val(id_sekolah);
            $('input[name=id_user]').val(id_user);
        })
    });
    
</script>

@endsection
