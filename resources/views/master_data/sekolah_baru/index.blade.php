@extends('layouts.template_app')

@section('title', '- Menu Sekolah')

@section('content')

@include('includes.navbar')

<div class="container">
    <div class="columns">
        <div class="column is-8">
            <h1 class="title ">Verifikasi Sekolah Baru</h1>
            @if (session('status'))
                <div class="notification is-info column is-5">
                    <button class="delete deleteNotif"></button>
                    {{ session('status') }}
                </div>
            @endif
        </div>
        <div class="column is-4">
            <a href="#" class="button is-link addBtn is-pulled-right">Tambah </a>
        </div>
    </div>
    <div class="columns is-multiline">

        <div class="column is-12 ">
            
            <div class="columns">
                <div class="column">
                    <div class="tabel-container">
                        <table class="table" id="table_sekolah">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="is-hidden">ID</th>
                                    <th>Nama Sekolah</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th class="is-hidden">ID</th>
                                    <th>Nama Sekolah</th>
                                    <th>Opsi</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($schools as $sekolah)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td class="is-hidden">{{ $sekolah['id_sekolah'] }}</td>
                                    <td>{{ $sekolah['nama_sekolah'] }}</td>
                                    <td>
                                        <button data-idSekolah="{{ $sekolah['id_sekolah'] }}" class="button is-small is-primary verifBtn"> Verifikasi </button>
                                        <button data-idSekolah="{{ $sekolah['id_sekolah'] }}" class="button is-small is-success editBtn"> Edit </button>
                                        <button data-idSekolah="{{ $sekolah['id_sekolah'] }}" class="button is-small is-danger deleteBtn"> Hapus </button>
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

    <div class="modal" id="modal_tambah">
        <div class="modal-background"></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">
                <span class="icon-text has-text-info">
                    <span class="icon">
                        <i class="fas fa-plus"></i>  
                    </span>
                    <span>Tambah Sekolah Baru</span>
                </span>
            </p>
            <button class="delete modal-closed" aria-label="close"></button>
          </header>
          <form method="post" action="{{ route('new_sekolah.store') }}" id="addForm">
            <section class="modal-card-body">
                @csrf
                <div class="field">
                    <label class="label" for="namaSekolah">Nama Sekolah</label>
                    <p class="control has-icons-left has-icons-right">
                      <input name="nama_sekolah" id="namaSekolah" class="input @error('nama_sekolah') is-invalid @enderror" type="text" placeholder="Nama Sekolah" required>
                      <span class="icon is-small is-left">
                        <i class="fas fa-school"></i>
                      </span>
                    </p>
                    @error('nama_sekolah')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </section>
                <footer class="modal-card-foot">
                    <button type="submit" class="button is-link">Tambah</button>
                    <a href="#" class="button modal-closed">Batal</a> 
                </footer>
            </form>
        </div>
    </div>

    <div class="modal" id="modal_edit">
        <div class="modal-background"></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">
                <span class="icon-text has-text-success">
                    <span class="icon">
                        <i class="fas fa-edit"></i>  
                    </span>
                    <span>Edit Sekolah Baru</span>
                </span>
            </p>
            <button class="delete modal-closed" aria-label="close"></button>
          </header>
          <form method="post" action="" id="editForm">
            <section class="modal-card-body">
                @method('put')
                @csrf
                <div class="field">
                    <label class="label" for="nama_sekolah">Nama Sekolah</label>
                    <p class="control has-icons-left has-icons-right">
                      <input value="" name="nama_sekolah" id="nama_sekolah" class="input @error('nama_sekolah') is-invalid @enderror" type="text" placeholder="Nama Sekolah" required>
                      <span class="icon is-small is-left">
                        <i class="fas fa-school"></i>
                      </span>
                    </p>
                    @error('nama_sekolah')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </section>
                <footer class="modal-card-foot">
                    <button type="submit" class="button is-success">Edit</button>
                    <a href="#" class="button modal-closed">Batal</a>
                </footer>
            </form>
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
                <p>Apa anda yakin ingin menghapus data <span id="namaSekolahHps"></span> ?</p>
                <input type="hidden" name="id_sekolah" id="id_sekolah">
            </section>
                <footer class="modal-card-foot">
                    <button type="submit" class="button is-danger">Hapus</button>
                    <a href="#" class="button modal-closed">Batal</a>
                </footer>
            </form>
        </div>
    </div>

    <div class="modal" id="modal_verif">
        <div class="modal-background"></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">
                <span class="icon-text has-text-primary">
                    <span class="icon">
                        <i class="fas fa-exclamation-circle"></i>  
                    </span>
                    <span>Verifikasi Sekolah</span>
                </span>
            </p>
            <button class="delete modal-closed" aria-label="close"></button>
          </header>
          <form method="post" action="" id="verifyForm">
            <section class="modal-card-body">
                @csrf
                <p>Apa anda yakin ingin memverifikasi data <span id="namaSekolahVerif"></span> ?</p>
                <input type="hidden" name="nama_sekolah" id="nama_sekolah_verif">
            </section>
                <footer class="modal-card-foot">
                    <button type="submit" class="button is-primary">Verifikasi</button>
                    <a href="#" class="button modal-closed">Batal</a>
                </footer>
            </form>
        </div>
    </div>

</div>
<script>
    $(document).ready(function () {
        
        var table = $('#table_sekolah').DataTable();

        $('.addBtn').click(function () {
            $('#modal_tambah').addClass('is-active');
        })

        $('#table_sekolah tbody').on('click', '.editBtn', function(){

            $tr = $(this).closest('tr');
            if($($tr).hasClass('child')) {
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);

            $('#idSekolah').val(data[1]);
            $('#nama_sekolah').val(data[2]);
            $('#editForm').attr('action', '/sekolah/'+data[1]);

            $('#modal_edit').addClass('is-active');

        })

        $('#table_sekolah tbody').on('click', '.deleteBtn', function(){

            $tr = $(this).closest('tr');
            if($($tr).hasClass('child')) {
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);
            
            $('#idSekolah').val(data[1]);
            $('#namaSekolahHps').html(data[2]);
            $('#deleteForm').attr('action', '/sekolah/'+data[1]);

            $('#modal_hapus').addClass('is-active');
            
        })

        $('#table_sekolah tbody').on('click', '.verifBtn', function(){

            $tr = $(this).closest('tr');
            if($($tr).hasClass('child')) {
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);

            $('#namaSekolahVerif').html(data[2]);
            $('#nama_sekolah_verif').val(data[2]);
            $('#verifyForm').attr('action', '/sekolah/'+data[1]+'/verify');

            $('#modal_verif').addClass('is-active');

        })

        $('.modal-closed').on('click', function () {
            $('#modal_tambah').removeClass('is-active');
            $('#modal_edit').removeClass('is-active');
            $('#modal_hapus').removeClass('is-active');
            $('#modal_verif').removeClass('is-active');
        })

        $('.deleteNotif').on('click', function () {
            $('.notification').addClass('is-hidden')
        })
    });


</script>
@endsection
