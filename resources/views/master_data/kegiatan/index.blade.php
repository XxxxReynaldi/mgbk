@extends('layouts.template_app')

@section('title', '- Menu Kegiatan')

@section('content')

@include('includes.navbar')

<div class="container">
    <div class="columns">
        <div class="column is-8">
            <h1 class="title ">Kegiatan</h1>
        </div>
        <div class="column is-4">
            <a href="{{ route('kegiatan.create') }}" class="button is-link is-pulled-right">Tambah Kegiatan</a>
        </div>
    </div>
    <div class="columns is-multiline">

        <div class="column is-12 ">
            
            <div class="columns">
                <div class="column">
                    <div class="tabel-container">
                        <table class="table" id="table-kegiatan">
                            <thead>
                                <tr>
                                    <th>#</th>
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
                                <tr>
                                    <th>1</th>
                                    <td>Kegiatan A</td>
                                    <td>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi cumque
                                        recusandae, iste odit quas doloribus!</td>
                                    <td>18 Januari 2021</td>
                                    <td>20 Januari 2021</td>
                                    <td>Lorem, ipsum dolor.</td>
                                    <td>Lorem, ipsum dolor.</td>
                                    <td>Lorem, ipsum dolor.</td>
                                    <td>Lorem, ipsum dolor.</td>
                                    <td>Lorem, ipsum dolor.</td>
                                    <td>
                                        <a href="#" class="button is-small is-success">Cetak</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>2</th>
                                    <td>Kegiatan B</td>
                                    <td>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi cumque
                                        recusandae, iste odit quas doloribus!</td>
                                    <td>18 Januari 2021</td>
                                    <td>20 Januari 2021</td>
                                    <td>Lorem, ipsum dolor.</td>
                                    <td>Lorem, ipsum dolor.</td>
                                    <td>Lorem, ipsum dolor.</td>
                                    <td>Lorem, ipsum dolor.</td>
                                    <td>Lorem, ipsum dolor.</td>
                                    <td>
                                        <a href="#" class="button is-small is-success">Cetak</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#table-kegiatan').DataTable();
    });
</script>
@endsection
