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
            <form method="POST" action="{{ url('admin/kegiatan') }}">
                @csrf
                <div class="field">
                    <label class="label" for="sasaran_kegiatan">Sasaran Kegiatan</label>
                    <div class="field">
                        <div class="control">
                          <div class="select is-primary is-fullwidth">
                            <select name="sasaran_kegiatan" id="sasaran_kegiatan">
                              <option selected disabled> -- Pilih --</option>
                              <option value="individu">Individu</option>
                              <option value="kelompok">Kelompok</option>
                              <option value="kelas">Kelas</option>
                              <option value="pihak lain">Pihak lain</option>
                              <option value="guru bk">Guru BK</option>
                            </select>
                          </div>
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
                            <input name="durasi" id="durasi" class="input" type="number" min="0" placeholder="Durasi">
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
                            <input name="jumlah_pertemuan" id="jumlah_pertemuan" class="input" type="number" min="1" placeholder="Jumlah Pertemuan">
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
                        <div class="columns">
                            <div class="column">
                                <a href="{{ url('admin/kegiatan') }}" class="button is-fullwidth"> Batal </a>
                            </div>
                            <div class="column">
                                <button type="submit" class="button is-success is-fullwidth">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
