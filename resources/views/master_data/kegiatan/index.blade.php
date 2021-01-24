@extends('layouts.template_app')

@section('title', '- Menu Kegiatan')

@section('content')

@include('includes.navbar')

<div class="container">
    <div class="columns">
        <div class="column is-8">
            <h1 class="title ">Kegiatan</h1>
            @if (session('status'))
                <div class="notification is-info column is-5">
                    <button class="delete deleteNotif"></button>
                    {{ session('status') }}
                </div>
            @endif
        </div>
        <div class="column is-4">
            <a href="{{ route('kegiatan.create') }}" class="button is-link is-pulled-right">Tambah </a>
        </div>
    </div>
    <div class="columns is-multiline">

        <div class="column is-12 ">
            
            <div class="columns">
                <div class="column">
                    <div class="tabel-container">
                        <table class="table" id="table_kegiatan">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="is-hidden">ID</th>
                                    <th>Sasaran Kegiatan</th>
                                    <th>Kegiatan</th>
                                    <th>Satuan Kegiatan</th>
                                    <th>Uraian</th>
                                    <th>Pelaporan</th>
                                    <th>Durasi</th>
                                    <th>Satuan waktu</th>
                                    <th>Jumlah Pertemuan</th>
                                    <th>Ekuivalen</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th class="is-hidden">ID</th>
                                    <th>Sasaran Kegiatan</th>
                                    <th>Kegiatan</th>
                                    <th>Satuan Kegiatan</th>
                                    <th>Uraian</th>
                                    <th>Pelaporan</th>
                                    <th>Durasi</th>
                                    <th>Satuan waktu</th>
                                    <th>Jumlah Pertemuan</th>
                                    <th>Ekuivalen</th>
                                    <th>Opsi</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($activities as $kegiatan)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td class="is-hidden">{{ $kegiatan['id_kegiatan'] }}</td>
                                    <td>{{ $kegiatan['sasaran_kegiatan'] }}</td>
                                    <td>{{ $kegiatan['kegiatan'] }}</td>
                                    <td>{{ $kegiatan['satuan_kegiatan'] }}</td>
                                    <td>{{ $kegiatan['uraian'] }}</td>
                                    <td>{{ $kegiatan['pelaporan'] }}</td>
                                    <td>{{ $kegiatan['durasi'] }}</td>
                                    <td>{{ $kegiatan['satuan_waktu'] }}</td>
                                    <td>{{ $kegiatan['jumlah_pertemuan'] }}</td>
                                    <td>{{ $kegiatan['ekuivalen'] }}</td>
                                    <td>
                                        <a href="{{ route('kegiatan.edit', [$kegiatan->id_kegiatan]) }}" class="button is-small is-success"> Edit </a>
                                        <button data-idKegiatan="{{ $kegiatan['id_kegiatan'] }}" class="button is-small is-danger deleteBtn"> Hapus </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        
    </div>

    <div class="modal" id="modal_hapus">
        <div class="modal-background"></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">
                <span class="icon-text has-text-danger">
                    <span class="icon">
                        <i class="fas fa-exclamation-triangle"></i>  
                    </span>
                    <span>Konfirmasi Hapus</span>
                </span>
            </p>
            <button class="delete modal-closed" aria-label="close"></button>
          </header>
          <form method="post" action="" id="deleteForm">
            <section class="modal-card-body">
                @method('delete')
                @csrf
                <p>Apa anda yakin ingin menghapus data <span id="namaKegiatan"></span> ?</p>
                <input type="hidden" name="id_kegiatan" id="idKegiatan">
            </section>
                <footer class="modal-card-foot">
                    <button type="submit" class="button is-danger">Hapus</button>
                    <a href="#" class="button modal-closed">Batal</a>
                </footer>
            </form>
        </div>
    </div>

</div>
<script>
    $(document).ready(function () {
        
        var table = $('#table_kegiatan').DataTable();

        // const modal     = document.querySelector('.modal');

        $('#table_kegiatan tbody').on('click', '.deleteBtn', function(){

            $tr = $(this).closest('tr');
            if($($tr).hasClass('child')) {
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);
            
            $('#idKegiatan').val(data[1]);
            $('#namaKegiatan').html(data[3]);
            $('#deleteForm').attr('action', '/kegiatan/'+data[1]);

            $('.modal').addClass('is-active');
            // modal.classList.add('is-active');
        })

        $('.modal-closed').on('click', function () {
            $('#modal_hapus').removeClass('is-active');
        })

        $('.deleteNotif').on('click', function () {
            $('.notification').addClass('is-hidden')
        })
    });
</script>
@endsection
