@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="page-head">
    <h1>Login</h1>
</div>

<form class="card form" method="POST" action="{{ route('login') }}" novalidate>
    @csrf

    <div class="field">
        <label for="email">Email</label>
        <input class="input @error('email') is-invalid @enderror" type="email" id="email" name="email"
            value="{{ old('email') }}" autocomplete="username" autofocus>
        @error('email') <small class="error">{{ $message }}</small> @enderror
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input class="input @error('password') is-invalid @enderror" type="password" id="password"
            name="password" autocomplete="current-password">
        @error('password') <small class="error">{{ $message }}</small> @enderror
    </div>

    <div class="field">
        <label class="check"><input type="checkbox" name="remember" value="1"> Stay connected</label>
    </div>

    <div class="actions">
        <a class="btn" href="{{ route('contacts.index') }}">Return to the list</a>
        <button type="submit" class="btn btn--primary">Login</button>
    </div>
</form>
@endsection
