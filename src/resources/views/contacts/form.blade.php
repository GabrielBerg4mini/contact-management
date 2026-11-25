@extends('layouts.app')

@php($editing = $contact->exists)

@section('title', $editing ? 'Edit contact' : 'New contact')

@section('content')
<div class="page-head">
    <h1>{{ $editing ? 'Edit contact' : 'New contact' }}</h1>
</div>

<form class="card form" method="POST" novalidate
    action="{{ $editing ? route('contacts.update', $contact) : route('contacts.store') }}">
    @csrf
    @if ($editing)
    @method('PUT')
    @endif

    <div class="field">
        <label for="name">Name</label>
        <input class="input @error('name') is-invalid @enderror" type="text" id="name" name="name"
            value="{{ old('name', $contact->name) }}" autocomplete="off">
        @error('name') <small class="error">{{ $message }}</small> @enderror
    </div>

    <div class="field">
        <label for="contact">Contact <span class="hint">(9 dígitos)</span></label>
        <input class="input @error('contact') is-invalid @enderror" type="text" id="contact" name="contact"
            value="{{ old('contact', $contact->contact) }}" inputmode="numeric" maxlength="9" autocomplete="off">
        @error('contact') <small class="error">{{ $message }}</small> @enderror
    </div>

    <div class="field">
        <label for="email">Email</label>
        <input class="input @error('email') is-invalid @enderror" type="email" id="email" name="email"
            value="{{ old('email', $contact->email) }}" autocomplete="off">
        @error('email') <small class="error">{{ $message }}</small> @enderror
    </div>

    <div class="actions">
        <a class="btn" href="{{ $editing ? route('contacts.show', $contact) : route('contacts.index') }}">Cancel</a>
        <button type="submit" class="btn btn--primary">{{ $editing ? 'Save changes' : 'Add contact' }}</button>
    </div>
</form>
@endsection
