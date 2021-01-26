@extends('layouts.template_login')

@section('content')
<div class="container">
    <div class="columns is-centered">
        <div class="column is-4">

            <div class="card">
                @if (session('status'))
                    <div class="notification is-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card-content">
                    <h1 class="title">Lupa Password</h1>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="field">
                            <label for="inputEmail" class="label">Email</label>
                            <p class="control has-icons-left">
                                <input type="email" id="inputEmail" class="input @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email" >
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </p>
                            <p class="help">
                                <em>
                                    * Setelah meng-klik tombol dibawah ini, Anda akan
                                    menerima email untuk mereset password Anda.
                                </em>
                            </p>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="field">
                            <p class="control">
                                <button type="submit" class="button is-link is-fullwidth">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </p>
                        </div>
                    </form>
                    <div class="field">
                        <div class="divider">Atau</div>
                    </div>
                    <div class="field">
                        <p class="control">
                            @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="button is-light is-fullwidth">
                                <span>
                                    Login
                                </span>
                            </a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <p class="has-text-centered mt-4">
                Belum punya akun?
                @if (Route::has('register'))
                <a href="{{ route('register') }}">
                    <u>
                       Daftar Disini!
                    </u>
                </a>
                @endif
            </p>

            <p class="mt-4 has-text-centered">
                &copy; MGBK Malang
            </p>


        </div>
    </div>
</div>
@endsection
