@extends('layouts.template_app')

@section('title', '- Tambah Kegiatan')

@section('content')

@include('includes.navbar')

<div class="container">
    <div class="columns">
        <div class="column">
            <h1 class="title is-5">Tambah Kegiatan</h1>
        </div>
    </div>

    <div class="columns is-centered">
        <div class="column is-5">
            <form>
                <div class="field">
                    <label class="label" for="sasaran_kegiatan">Sasaran Kegiatan</label>
                    <div class="field">
                        <div class="control">
                            <input name="sasaran_kegiatan" id="sasaran_kegiatan" class="input" type="text" placeholder="Sasaran Kegiatan" autofocus>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="kegiatan">Kegiatan</label>
                    <div class="field">
                        <div class="control">
                            <input name="kegiatan" id="kegiatan" class="input" type="text" placeholder="Kegiatan">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="satuan_kegiatan">Satuan Kegiatan</label>
                    <div class="field">
                        <div class="control">
                            <input name="satuan_kegiatan" id="satuan_kegiatan" class="input" type="text" placeholder="Satuan Kegiatan">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="uraian">Uraian</label>
                    <div class="field">
                        <div class="control">
                            <textarea name="uraian" id="uraian" class="textarea" placeholder="Uraian"></textarea>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="pelaporan">Pelaporan</label>
                    <div class="field">
                        <div class="control">
                            <input name="pelaporan" id="pelaporan" class="input" type="text" placeholder="Pelaporan">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="durasi">Durasi</label>
                    <div class="field">
                        <div class="control">
                            <input name="durasi" id="durasi" class="input" type="number" placeholder="Durasi">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="satuan_waktu">Satuan Waktu</label>
                    <div class="field">
                        <div class="control">
                            <input name="satuan_waktu" id="satuan_waktu" class="input" type="text" placeholder="Satuan Waktu">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="jumlah_pertemuan">Jumlah Pertemuan</label>
                    <div class="field">
                        <div class="control">
                            <input name="jumlah_pertemuan" id="jumlah_pertemuan" class="input" type="number" min="0" placeholder="Jumlah Pertemuan">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="ekuivalen">Ekuivalen</label>
                    <div class="field">
                        <div class="control">
                            <input name="ekuivalen" id="ekuivalen" class="input" type="number" step="0.01" min="0" placeholder="Ekuivalen">
                        </div>
                    </div>
                </div>
                <div class="field mt-4">
                    <div class="control">
                        <button class="button is-success is-fullwidth">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
