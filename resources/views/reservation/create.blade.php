@extends('layouts.app')

@section('content')

@if ($errors->any())
    <div style="color:red; margin-bottom:20px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container">
    <h1>Nieuwe Reservering</h1>

    <hr>

    <div style="padding: 15px; border: 1px solid #ccc; margin-bottom: 20px;">
        <h3>Huidige tarieven:</h3>
        <p><strong>Basistarief:</strong> €{{ number_format($settings->base_price, 2) }}</p>
        <p><strong>Extra toeslag (bij meerdere spelers):</strong> €{{ number_format($settings->extra_fee, 2) }}</p>
        <p><strong>Maximaal aantal spelers:</strong> {{ $settings->player_limit }}</p>
    </div>

    <form method="POST" action="{{ route('reservation.calculate') }}">
        @csrf

        <hr>

        @for ($i = 0; $i < $settings->player_limit; $i++)
            <div>
                <label>Speler {{ $i + 1 }}</label>

                <select name="membership[]" class="form-select">

                    @foreach($playerTypes as $playerType)
                    <option value="{{ $playerType['value'] }}">
                        {{ $playerType['label'] }}
                    </option>
                    @endforeach

                </select>
            </div>
        @endfor

        <hr>

        <hr>

        <button type="submit">Bereken</button>
    </form>
</div>

@endsection