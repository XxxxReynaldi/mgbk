@extends('layouts.template_app')

@section('content')

@include('includes.navbar')

<div class="container">
    <div class="columns is-centered">
        <div class="column is-half">
            <div class="card mt-6">
                <header class="card-header">
                    <p class="card-header-title">
                        Konfirmasi email Anda
                    </p>
                </header>
                <div class="card-content">
                    <div class="content">
                        Sebelum melanjutkan harap konfirmasi email Anda melalui link yang telah kami kirim. Jika Anda tidak mendapat email, klik link dibawah ini.
                    </div>
                </div>
                {{-- <form class="d-inline" method="POST" action="{{ route('verification.resend') }}"> --}}
                <form class="d-inline" method="POST" action="/email/verification-notification">
                    <footer class="card-footer">
                        @csrf
                            <button type="submit" class="button is-fullwidth is-primary is-light">{{ __('Kirim email lagi') }}</button>
                    </footer>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
