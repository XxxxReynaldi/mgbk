@extends('layouts.template_app')

@section('content')

@include('includes.navbar')

<div class="container">
    <div class="columns">
        <div class="column">
            <h1 class="title is-5">Laporan Bulanan</h1>
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
        <div class="columns">
            <div class="column is-4">
                <div class="field">
                    <label class="label">Pilih Sekolah</label>
                    <div class="control">
                        <div class="is-fullwidth">
                            <select name="id_sekolah" id="sekolah" class="select-filter filter" style="width: 100%">
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
                            <select name="id_user" id="guru" class="select-filter filterr" style="width: 100%">
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

    <h1 class="title is-5">Bulanan</h1>

    <div class="columns">
        <div class="column">
            <div class="tabel-container">
                <table class="table is-fullwidth" id="table-laporan">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kegiatan</th>
                            <th>Detail</th>
                            <th>Tanggal transaksi</th>
                            <th>Upload document 1</th>
                            <th>Upload document 2</th>
                            <th>Upload document 3</th>
                            {{-- <th>Opsi</th> --}}
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama Kegiatan</th>
                            <th>Detail</th>
                            <th>Tanggal transaksi</th>
                            <th>Upload document 1</th>
                            <th>Upload document 2</th>
                            <th>Upload document 3</th>
                            {{-- <th>Opsi</th> --}}
                        </tr>
                    </tfoot>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <a href="#" class="button is-warning is-fullwidth">
        <span>
            Cetak Semua
        </span>
        <span class="icon">
            <i class="fas fa-long-arrow-alt-right"></i>
        </span>
    </a>

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
        $('#tahun').select2({
            placeholder: "Pilih Tahun",
            allowClear: true
        });
        $('#bulan').select2({
            placeholder: "Pilih Bulan",
            allowClear: true
        });

        
        $('#sekolah').on('change', function () {
            var id_sekolah = $(this).val();
            // console.log(id_sekolah);

            $.ajax({
                url         : '{{ route('admin.laporan.load-guru') }}',
                type        : 'get',
                dataType    : 'json',
                data        : {
                    'id_sekolah': id_sekolah
                },
                success: function (response) {
                    // console.log('success');
                    // console.log(response);

                    $('#guru').empty();
                    $('#guru').append('<option value="">-- Pilih Guru --</option>');

                    $.each(response, function (id_profile, nama_lengkap) {
                        $('#guru').append(new Option(nama_lengkap, id_profile))
                    });
                    $('#guru').show(150);

                }
            });
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
            console.log([laporan, id_sekolah, id_user, year, month]);
        })

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
                    d.id_sekolah    = $('select[name=id_sekolah]').val();;
                    d.id_user       = $('select[name=id_user]').val();
                    d.year          = $('select[name=year]').val();
                    d.month         = $('select[name=month]').val();
                    console.log([d.laporan, d.id_sekolah, d.id_user, d.year, d.month]);
                },
                
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'kegiatan', name: 'kegiatan' },
                { data: 'detail', name: 'laporan.detail' },
                { data: 'tgl_transaksi', name: 'laporan.tgl_transaksi' },
                { data: 'upload_doc_1', name: 'laporan.upload_doc_1' },
                { data: 'upload_doc_2', name: 'laporan.upload_doc_2' },
                { data: 'upload_doc_3', name: 'laporan.upload_doc_3' },
            ],
        });

        $('#search-form').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        });
    });
</script>

@endsection