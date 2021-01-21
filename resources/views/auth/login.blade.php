@extends('layouts.template_login')

@section('content')
<div class="container">
    <div class="columns is-centered">
        <div class="column is-4">

            <div class="card">
                <div class="card-content">
                    <h1 class="title">Login</h1>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="field">
                            <label for="inputEmail" class="label">Email</label>
                            <p class="control has-icons-left">
                                <input type="email" name="email" id="inputEmail" autocomplete="email" class="input @error('email') is-invalid @enderror"
                                    placeholder="Email" value="{{ old('email') }}" required autofocus>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </p>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="inputPassword" class="label">Password</label>
                            <p class="control has-icons-left">
                                <input type="password" name="password" id="inputPassword" class="input @error('password') is-invalid @enderror"
                                    placeholder="Password" required autocomplete="current-password">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </p>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="field">
                            <label class="checkbox">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                Ingat saya
                            </label>
                        </div>
                        <div class="field">
                            <p class="control">
                                <button type="submit" class="button is-link is-fullwidth">
                                    <span class="icon">
                                        <i class="fas fa-sign-in-alt"></i>
                                    </span>
                                    <span>
                                        {{ __('Login') }}
                                    </span>
                                </button>
                            </p>
                        </div>
                        <div class="field">
                            <div class="divider">Atau</div>
                        </div>
                        <div class="field">
                            <p class="control">
                                @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="button is-light is-fullwidth">
                                    <span>
                                        Daftar
                                    </span>
                                </a>
                                @endif
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <p class="has-text-centered mt-4">
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    <u>
                        Lupa Password?
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
