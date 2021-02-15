@extends('layouts.template_app')

@section('content')

@include('includes.navbar')

<div class="container">
    <div class="columns">
        <div class="column">
            <h1 class="title is-5">Laporan Semesteran</h1>
        </div>
    </div>

    <div class="columns">
        <div class="column is-4">
            <div class="field">
                <label class="label">Pilih Sekolah</label>
                <div class="control">
                    <div class="select is-fullwidth">
                        <select>
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
                        <select>
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
                <label class="label">Pilih Semester</label>
                <div class="control">
                    <div class="select is-fullwidth">
                        <select>
                            <option>-- Pilih Semester --</option>
                            <option>Ganjil 2019</option>
                            <option>Genap 2019</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <h1 class="title is-5">Semesteran</h1>

    <div class="columns">
        <div class="column">
            <div class="tabel-container">
                <table class="table" id="table-laporan">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kegiatan</th>
                            <th>Jumlah Kegiatan</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama Kegiatan</th>
                            <th>Jumlah Kegiatan</th>
                            <th>Detail</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <th>1</th>
                            <td>Kegiatan A</td>
                            <td>8 Kali</td>
                            <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio aut et nihil
                                necessitatibus architecto laboriosam.</td>
                        </tr>
                        <tr>
                            <th>1</th>
                            <td>Kegiatan B</td>
                            <td>6 Kali</td>
                            <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio aut et nihil
                                necessitatibus architecto laboriosam.</td>
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