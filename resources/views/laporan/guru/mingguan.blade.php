@extends('layouts.template_app')

@section('content')

@include('includes.navbar')

<div class="container">
    <div class="columns">
        <div class="column">
            <h1 class="title is-5">Laporan Mingguan</h1>
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

    <form action="" method="POST" id="search-form">
        @csrf
        <input type="hidden" id="laporan" name="laporan" value="mingguan">
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
                                @foreach ($years as $year => $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
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
                    <label class="label">Pilih Minggu</label>
                    <div class="control">
                        <div class="is-fullwidth">
                            <select name="id_week" id="minggu" class="select-filter filter" style="width: 100%">
                                <option></option>
                                @foreach ($weeks as $id_week => $week)
                                    <option value="{{ $id_week }}">{{ $week }}</option>
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
            <h1 class="title is-5 mb-2">Mingguan </h1>
            <p class="control">
                <a class="button is-info importBtn"><i class="fas fa-file-import fa-fw" aria-hidden="true"></i>&nbsp; Import </a>
            </p>
        </div>
        <div class="column is-half is-vcentered">
            <div class="field is-grouped is-grouped-right">
                <form action="{{ route('user.laporan.print.week') }}" method="post" id="print-form">
                    @csrf
                    <input type="hidden" id="id_sekolah-p" name="id_sekolah-p" value="">
                    <input type="hidden" id="id_user-p" name="id_user-p" value="">
                    <input type="hidden" id="year-p" name="year-p" value="">
                    <input type="hidden" id="id_week-p" name="id_week-p" value="">
                    <label class="checkbox mr-3 mb-2">
                        <input type="checkbox" name="with_header" value="1">
                        Sertakan Header
                    </label> <br>
                    <button type="submit" class="button is-warning is-fullwidth"><i class="fas fa-print fa-fw" aria-hidden="true"></i>&nbsp; Cetak </button>
                </form>
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
        $('#minggu').select2({
            placeholder: "Pilih Minggu",
            allowClear: true
        });

        $('#tahun').on('change', function () {
            var year = $(this).val();
            // console.log(year);

            $.ajax({
                url         : '{{ route('user.laporan.load-weeks') }}',
                type        : 'get',
                dataType    : 'json',
                data        : {
                    'year': year
                },
                success: function (response) {
                    // console.log('success');
                    // console.log(response);

                    $('#minggu').empty();
                    $('#minggu').append('<option value="">-- Pilih minggu --</option>');

                    $.each(response, function (id_week, week) {
                        $('#minggu').append(new Option(week, id_week))
                    });
                    $('#minggu').show(150);

                }
            });
        });

        let laporan         = $('#laporan').val();
        let id_sekolah      = $('#sekolah').val();
        let id_user         = $('#guru').val();
        let year            = $('#tahun').val();
        let id_week         = $('#minggu').val();
        
        $('.filter').on('change',function () {
            id_sekolah      = $('#sekolah').val();
            id_user         = $('#guru').val();
            year            = $('#tahun').val();
            id_week         = $('#minggu').val();
            // console.log([laporan, id_sekolah, id_user, year, id_week]);

            $('#id_sekolah-p').val(id_sekolah);      
            $('#id_user-p').val(id_user);
            $('#year-p').val(year);
            $('#id_week-p').val(id_week);
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

        const fileInput = document.querySelector('#file-js-example input[type=file]');
        fileInput.onchange = () => {
            if (fileInput.files.length > 0) {
            const fileName = document.querySelector('#file-js-example .file-name');
            fileName.textContent = fileInput.files[0].name;
            }
        }
        
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
                    d.id_week       = $('select[name=id_week]').val();
                    console.log([d.laporan, d.id_sekolah, d.id_user, d.year, d.id_week]);
                },
                
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'kegiatan', name: 'kegiatan' },
                { data: 'tgl_transaksi', name: 'tgl_transaksi' },
                { data: 'detail', name: 'detail' },
                // { data: 'upload_doc_1', name: 'upload_doc_1' },
                // { data: 'upload_doc_2', name: 'upload_doc_2' },
            ],
        });

        $('#search-form').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        });
    });
</script>

@endsection