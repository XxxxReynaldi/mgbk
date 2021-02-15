@extends('layouts.template_app')

@section('content')

@include('includes.navbar')

<div class="container">
    <div class="columns">
        <div class="column">
            <h1 class="title is-5">Perbarui Profil</h1>
        </div>
    </div>

    <div class="columns is-centered">
        <div class="column is-6">
            <form method="POST" action="{{ route('user-profile-information.update') }}">
                @csrf
                @method('PUT')
                <div class="field">
                    <label class="label" for="nama">Nama </label>
                    <div class="control">
                        <input name="name" class="input @error('name') is-invalid @enderror" value="{{ old('name') ?? auth()->user()->name  }}" type="text" id="nama" placeholder="Nama " required autofocus>
                    </div>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="field">
                    <label class="label" for="email">Email</label>
                    <div class="control">
                        <input name="email" class="input @error('email') is-invalid @enderror" value="{{ old('email') ?? auth()->user()->email }}" type="email" id="email" placeholder="Email" required autofocus>
                        <p class="help">Gunakan alamat email asli.</p>
                    </div>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <hr class="divider">
                <div class="control">
                    <div class="columns">
                        <div class="column">
                        <button type="submit" class="button is-success is-fullwidth">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
</div>

@endsection
