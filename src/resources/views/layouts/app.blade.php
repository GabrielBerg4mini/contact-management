<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Contacts') - Contact Management</title>
    <link rel="stylesheet" href="{{ asset('css/contacts.css') }}">
</head>
<body>
    <header class="topbar">
        <div class="container topbar__inner">
            <a class="brand" href="{{ route('contacts.index') }}">Contact Management</a>
            <a class="btn btn--primary" href="{{ route('contacts.create') }}">+ Add Contact</a>
        </div>
    </header>

    <main class="container">
        @if (session('success'))
            <div class="alert alert--success" role="status">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    <script src="{{ asset('js/contacts.js') }}"></script>
</body>
</html>
