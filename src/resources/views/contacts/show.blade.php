@extends('layouts.app')

@section('title', 'Contact details')

@section('content')
<div class="page-head">
    <h1>Contact details</h1>
</div>

<div class="card details">
    <dl>
        <dt>ID</dt>
        <dd>{{ $contact->id }}</dd>
        <dt>Name</dt>
        <dd>{{ $contact->name }}</dd>
        <dt>Contact</dt>
        <dd>{{ $contact->contact }}</dd>
        <dt>Email</dt>
        <dd>{{ $contact->email }}</dd>
    </dl>

    <div class="actions">
        <a class="btn" href="{{ route('contacts.index') }}">← Return to list</a>
        <a class="btn btn--primary" href="{{ route('contacts.edit', $contact) }}">Edit</a>
        <form class="inline" method="POST" action="{{ route('contacts.destroy', $contact) }}"
            data-confirm="Delete the contact &quot;{{ $contact->name }}&quot;?">
            @csrf
            @method('DELETE')
            <button class="btn btn--danger" type="submit">Delete</button>
        </form>
    </div>
</div>
@endsection
