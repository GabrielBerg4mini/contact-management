@extends('layouts.app')

@section('title', 'Contacts')

@section('content')
<div class="page-head">
    <h1>Contacts</h1>
    <form method="GET" action="{{ route('contacts.index') }}" class="search">
        <input type="search" name="search" value="{{ $search }}" class="input input--search"
            placeholder="Search by name, contact, or email...">
        <button class="btn" type="submit">Search</button>
    </form>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($contacts as $contact)
            <tr>
                <td>{{ $contact->id }}</td>
                <td><a class="name-link" href="{{ route('contacts.show', $contact) }}">{{ $contact->name }}</a></td>
                <td>{{ $contact->contact }}</td>
                <td>{{ $contact->email }}</td>
                <td class="text-right">
                    <a class="btn btn--sm" href="{{ route('contacts.show', $contact) }}">View</a>
                    <a class="btn btn--sm" href="{{ route('contacts.edit', $contact) }}">Edit</a>
                    <form class="inline" method="POST" action="{{ route('contacts.destroy', $contact) }}"
                        data-confirm="Excluir o contato &quot;{{ $contact->name }}&quot;?">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn--sm btn--danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="empty">No contact found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination">{{ $contacts->links() }}</div>
</div>
@endsection
