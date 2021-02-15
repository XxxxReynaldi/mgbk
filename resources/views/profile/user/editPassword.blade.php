@extends('layouts.template_app')

@section('content')

@include('includes.navbar')

<div class="container">
    <div class="columns">
        <div class="column">
            <h1 class="title is-5">Ubah Password User</h1>
        </div>
    </div>

    <div class="columns is-centered">
        <div class="column is-6">
            <form method="POST" action="{{ route('user-password.update') }}">
                @csrf
                @method('PUT')
                @if (session('status') == "password-updated")
                    <div class="notification is-info column is-5">
                        <button class="delete deleteNotif"></button>
                        {{ __('Password berhasil diubah !') }}
                    </div>
                @endif
                <div class="field">
                    <label class="label" for="current_password">Password lama </label>
                    <div class="control">
                        <input name="current_password" class="input @error('current_password', 'updatePassword') is-invalid @enderror" type="password" id="current_password" placeholder="Password lama " required autofocus>
                    </div>
                    @error('current_password', 'updatePassword')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="field">
                    <label class="label" for="password">Password baru</label>
                    <div class="control">
                        <input name="password" class="input @error('password', 'updatePassword') is-invalid @enderror" type="password" id="password" placeholder="Password baru">
                    </div>
                    @error('password', 'updatePassword')
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
<script>
    $(document).ready(function () {
        $('.deleteNotif').on('click', function () {
            $('.notification').addClass('is-hidden')
        })
    });
</script>
@endsection
