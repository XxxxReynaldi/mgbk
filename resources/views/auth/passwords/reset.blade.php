@extends('layouts.template_login')

@section('content')

<div class="container">
    <div class="columns is-centered">
        <div class="column is-4">

            <div class="card">
                <div class="card-content">
                    <h1 class="title">Reset Password</h1>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <div class="field">
                            <label for="inputEmail" class="label">Email</label>
                            <p class="control">
                                <input type="email" name="email" id="inputEmail" class="input @error('email') is-invalid @enderror"
                                value="{{ $request->email }}" placeholder="Email" required readonly autofocus>
                            </p>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="inputPassword" class="label">Password</label>
                            <p class="control">
                                <input type="password" name="password" id="inputPassword" class="input @error('password') is-invalid @enderror" 
                                name="password" placeholder="Password" required autofocus>
                            </p>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="inputRepeatPassword" class="label">Konfirmasi Password</label>
                            <p class="control">
                                <input type="password" name="password_confirmation" id="inputRepeatPassword" class="input"
                                placeholder="Konfirmasi Password" required autocomplete="new-password">
                            </p>
                        </div>
                        <div class="field">
                            <p class="control">
                                <button type="submit" class="button is-link is-fullwidth">
                                    {{ __('Reset Password') }}
                                </button>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <p class="has-text-centered mt-4">
                @if (Route::has('login'))
                <a href="{{ route('login') }}" class="button is-light is-fullwidth">
                    <span>
                        Login
                    </span>
                </a>
                @endif
            </p>

            <p class="mt-4 has-text-centered">
                &copy; MGBK SMA Kota Malang
            </p>


        </div>
    </div>
</div>
@endsection
