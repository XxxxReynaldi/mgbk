@extends('layouts.template_app')

@section('content')

@include('includes.navbar')

<div class="container">
    <div class="columns">
        <div class="column">
            <h1 class="title is-5">Laporan Harian</h1>
        </div>
    </div>

    <form action="" method="POST">
        @csrf
        <div class="columns">
            <div class="column is-4">
                <div class="field">
                    <label class="label">Pilih Sekolah</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select name="id_sekolah">
                                <option>-- Pilih Sekolah --</option>
                                <option>SMA N 1 Malang</option>
                                <option>SMA N 2 Malang</option>
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
                        <div class="select is-fullwidth">
                            <select name="id_user">
                                <option>-- Pilih Guru --</option>
                                <option>Yahya Purnomo</option>
                                <option>Basuki</option>
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
                        <input name="tanggal" type="date" class="input">
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


    <h1 class="title is-5 mt-6">Harian</h1>

    <div class="columns">
        <div class="column">
            <div class="tabel-container">
                <table class="table" id="table-laporan">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kegiatan</th>
                            <th>Deskripsi</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Field</th>
                            <th>Field</th>
                            <th>Field</th>
                            <th>Field</th>
                            <th>Field</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama Kegiatan</th>
                            <th>Deskripsi</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Field</th>
                            <th>Field</th>
                            <th>Field</th>
                            <th>Field</th>
                            <th>Field</th>
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

    <a href="#" class="button is-warning is-fullwidth">
        <span>
            Cetak Semua
        </span>
        <span class="icon">
            <i class="fas fa-long-arrow-alt-right"></i>
        </span>
    </a>

</div>

@endsection