@extends('layouts.template_app')

@section('content')

@include('includes.navbar')

<div class="container">
    <div class="columns">
        <div class="column">
            <h1 class="title is-5">Laporan Bulanan</h1>
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
        </div>
    </div>

    @php
        $bln = array(
            1=>'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'July',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );

        $year_now = date('Y');

    @endphp

    <form action="" method="POST" id="search-form">
        @csrf
        <input type="hidden" id="laporan" name="laporan" value="bulanan">
        <input type="hidden" id="sekolah" name="id_sekolah" value="{{ $profile->id_sekolah }}">
        <input type="hidden" id="guru" name="id_user" value="{{ Auth::user()->id_user }}">
        <div class="columns">
            <div class="column is-4">
                <div class="field">
                    <label class="label">Pilih Tahun</label>
                    <div class="control">
                        <div class="is-fullwidth">
                            <select name="year" id="tahun" class="select-filter filter" style="width: 100%">
                                <option></option>
                                @for ($i = 1970; $i <= $year_now; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor 
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column is-4">
                <div class="field">
                    <label class="label">Pilih Bulan</label>
                    <div class="control">
                        <div class="is-fullwidth">
                            <select name="month" id="bulan" class="select-filter filter" style="width: 100%">
                                <option></option>
                                @foreach ($bln as $key => $val)
                                    <option value="{{ $key }}">{{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column is-4">
                <div class="field">
                <button type="submit" class="button is-link is-pulled-right">Cari </button>
                </div>
            </div>
        </div>

    </form>

  
    <div class="columns is-multiline is-mobile">        
        <div class="column is-half">
            <h1 class="title is-5 mb-2">Bulanan </h1>
            <p class="control">
                <a class="button is-info importBtn"><i class="fas fa-file-import fa-fw" aria-hidden="true"></i>&nbsp; Import </a>
            </p>
        </div>
        <div class="column is-half is-vcentered">
            <div class="field is-grouped is-grouped-right">
                <p class="control">
                    <form action="{{ route('user.laporan.print.month') }}" method="post" id="print-form">
                        @csrf
                        <input type="hidden" id="id_sekolah-p" name="id_sekolah-p" value="">
                        <input type="hidden" id="id_user-p" name="id_user-p" value="">
                        <input type="hidden" id="tahun-p" name="year-p" value="">
                        <input type="hidden" id="bulan-p" name="month-p" value="">
                        <label class="checkbox mr-3 mb-2">
                            <input type="checkbox" name="with_header" value="1">
                            Sertakan Header
                        </label> <br>
                        <button type="submit" class="button is-warning is-fullwidth"><i class="fas fa-print fa-fw" aria-hidden="true"></i>&nbsp; Cetak </button>
                    </form>
                </p>
            </div>
        </div>
    </div>

    <div class="columns">
        <div class="column">
            <div class="tabel-container">
                <table class="table is-fullwidth" id="table-laporan">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal transaksi</th>
                            <th style="width: 50%;">Detail</th>
                            {{-- <th>Upload document 1</th> --}}
                            {{-- <th>Upload document 2</th> --}}
                            {{-- <th>Opsi</th> --}}
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal transaksi</th>
                            <th style="width: 50%;">Detail</th>
                            {{-- <th>Upload document 1</th> --}}
                            {{-- <th>Upload document 2</th> --}}
                            {{-- <th>Opsi</th> --}}
                        </tr>
                    </tfoot>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- <a href="#" class="button is-warning is-fullwidth">
        <span>
            Cetak Semua
        </span>
        <span class="icon">
            <i class="fas fa-long-arrow-alt-right"></i>
        </span>
    </a> --}}

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

</div>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#tahun').select2({
            placeholder: "Pilih Tahun",
            allowClear: true
        });
        $('#bulan').select2({
            placeholder: "Pilih Bulan",
            allowClear: true
        });

        let laporan         = $('#laporan').val();
        let id_sekolah      = $('#sekolah').val();
        let id_user         = $('#guru').val();
        let year            = $('#tahun').val();
        let month           = $('#bulan').val();

        $('.filter').on('change',function () {
            id_sekolah      = $('#sekolah').val();
            id_user         = $('#guru').val();
            year            = $('#tahun').val();
            month           = $('#bulan').val();
            // console.log([laporan, id_sekolah, id_user, year, month]);

            $('#id_sekolah-p').val(id_sekolah);      
            $('#id_user-p').val(id_user);
            $('#tahun-p').val(year);
            $('#bulan-p').val(month);
        });

        $('.importBtn').click(function () {
            $('#modal_import').addClass('is-active');
            $('input[name=id_sekolah]').val(id_sekolah);
            $('input[name=id_user]').val(id_user);
        })

        $('.modal-closed').on('click', function () {
            $('#modal_import').removeClass('is-active');
        })

        $('.deleteNotif').on('click', function () {
            $('.notification').addClass('is-hidden')
        })    

        var table = $('#table-laporan').DataTable({

            searching: false,
            processing: true,
            serverSide: true,
            order: [[1, 'desc']],
            ajax: {
                url         : '{!! route('user.laporan.cari') !!}',
                type        : 'post',
                data        : function (d) {
                    d.laporan       = $('input[name=laporan]').val();
                    d.id_sekolah    = $('input[name=id_sekolah]').val();
                    d.id_user       = $('input[name=id_user]').val();
                    d.year          = $('select[name=year]').val();
                    d.month         = $('select[name=month]').val();
                    console.log([d.laporan, d.id_sekolah, d.id_user, d.year, d.month]);
                },
                
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'kegiatan', name: 'kegiatan' },
                { data: 'tgl_transaksi', name: 'laporan.tgl_transaksi' },
                { data: 'detail', name: 'laporan.detail' },
                // { data: 'upload_doc_1', name: 'laporan.upload_doc_1' },
                // { data: 'upload_doc_2', name: 'laporan.upload_doc_2' },
            ],
        });

        $('#search-form').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        });
    });
</script>

@endsection