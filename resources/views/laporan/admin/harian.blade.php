@extends('layouts.template_app')

@section('content')

@include('includes.navbar')

<div class="container">
    <div class="columns">
        <div class="column">
            <h1 class="title is-5">Laporan Harian</h1>
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
        <input type="hidden" id="laporan" name="laporan" value="harian">
        <div class="columns">
            <div class="column is-4">
                <div class="field">
                    <label class="label">Pilih Sekolah</label>
                    <div class="control">
                        <div class="is-fullwidth">
                            <select name="id_sekolah" id="sekolah" class="select-filter filter" style="width: 100%" required>
                                <option></option>
                                @foreach ($schools as $id_sekolah => $nama_sekolah)
                                    <option value="{{ $id_sekolah }}">{{ $nama_sekolah }}</option>
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
                    <label class="label">Pilih Guru</label>
                    <div class="control">
                        <div class="is-fullwidth">
                            <select name="id_user" id="guru" class="select-filter filter" style="width: 100%" required>
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column is-4">
                <div class="field">
                    <label class="label">Pilih Tanggal</label>
                    <div class="control">
                        <input id="tgl" name="tgl_transaksi" type="date" class="input filter" required>
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
            <h1 class="title is-5">Harian </h1>
        </div>
        <div class="column is-half">
            <div class="field is-grouped is-grouped-right">
                {{-- <p class="control">
                    <a class="button is-info is-pulled-right importBtn"><i class="fas fa-file-import fa-fw" aria-hidden="true"></i>&nbsp; Import </a>
                </p> --}}
                <p class="control">
                    <form action="{{ route('admin.laporan.print.date') }}" method="post" id="print-form">
                        @csrf
                        <input type="hidden" id="id_sekolah-p" name="id_sekolah-p" value="">
                        <input type="hidden" id="id_user-p" name="id_user-p" value="">
                        <input type="hidden" id="tgl_transaksi-p" name="tgl_transaksi-p" value="">
                        <button type="submit" class="button is-warning is-pulled-right"><i class="fas fa-print fa-fw" aria-hidden="true"></i>&nbsp; Cetak </button>
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
                            <th style="width: 35%;">Detail</th>
                            <th>Upload document 1</th>
                            <th>Upload document 2</th>
                            {{-- <th>Opsi</th> --}}
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama Kegiatan</th>
                            <th style="width: 35%;">Detail</th>
                            <th>Upload document 1</th>
                            <th>Upload document 2</th>
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

        $('#sekolah').select2({
            placeholder: "Pilih Sekolah",
            allowClear: true
        });
        $('#guru').select2({
            placeholder: "Pilih Guru",
            allowClear: true
        });

        let laporan         = $('#laporan').val();
        let id_sekolah      = $('#sekolah').val();
        let id_user         = $('#guru').val();
        let tgl_transaksi   = $('#tgl').val();

        $('.filter').on('change',function () {
            id_sekolah      = $('#sekolah').val();
            id_user         = $('#guru').val();
            tgl_transaksi   = $('#tgl').val();
            // console.log([laporan, id_sekolah, id_user, tgl_transaksi]);

            $('#id_sekolah-p').val(id_sekolah);      
            $('#id_user-p').val(id_user);
            $('#tgl_transaksi-p').val(tgl_transaksi);
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
        
        $('#sekolah').on('change', function () {
            var id_sekolah = $(this).val();
            
            $.ajax({
                url         : '{{ route('admin.laporan.load-guru') }}',
                type        : 'get',
                dataType    : 'json',
                data        : {
                    'id_sekolah': id_sekolah
                },
                success: function (response) {
                    // console.log('success');
                    
                    $('#guru').empty();
                    $('#guru').append('<option value="">-- Pilih Guru --</option>');

                    $.each(response, function (id_user, nama_lengkap) {
                        $('#guru').append(new Option(nama_lengkap, id_user))
                    });
                    $('#guru').show(150);

                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        });

        var table = $('#table-laporan').DataTable({

            searching: false,
            processing: true,
            serverSide: true,
            order: [[1, 'desc']],
            ajax: {
                url         : '{!! route('admin.laporan.cari') !!}',
                type        : 'post',
                data        : function (d) {
                    d.laporan       = $('input[name=laporan]').val();
                    d.id_sekolah    = $('select[name=id_sekolah]').val();
                    d.id_user       = $('select[name=id_user]').val();
                    d.tgl_transaksi = $('input[name=tgl_transaksi]').val();
                    console.log([d.laporan, d.id_sekolah, d.id_user, d.tgl_transaksi]);
                },
                
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'kegiatan', name: 'kegiatan' },
                { data: 'detail', name: 'detail' },
                { data: 'upload_doc_1', name: 'upload_doc_1' },
                { data: 'upload_doc_2', name: 'upload_doc_2' },
            ],
        });

        $('#search-form').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        });
    });
</script>

@endsection