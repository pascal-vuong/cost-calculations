@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Admin Dashboard</h1>

    <hr>

    <p>
        <strong>Totaal aantal gebruikers:</strong> {{ $userCount }}
    </p>

    <hr>

    <h2>Gebruikers overzicht</h2>

    @foreach($users as $user)
        <div style="margin-bottom: 15px; padding: 10px; border: 1px solid #ccc;">
            <p><strong>Naam:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>

            <p><strong>Rollen:</strong>
                @foreach($user->roles as $role)
                    {{ $role->name }}
                @endforeach
            </p>
        </div>
    @endforeach

</div>

@endsection